<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\RequestOptions;

class UserController extends Controller
{
    /**
     * Display a listing of the users
     *
     * @param  \App\User  $model
     * @return \Illuminate\View\View
     */
    public function index(User $model)
    { 
        $users = DB::table('users')
                ->select('users.*', 'reff_user_role.user_role_name')
                ->leftjoin('reff_user_role', 'reff_user_role.id', 'users.user_role_id')
                ->paginate(50);

        $reff_user_role = DB::table('reff_user_role')
                            ->get();
        
        $clients = DB::table('tb_clients')
                    ->get();

        $data['users'] = $users;
        $data['reff_user_role'] = $reff_user_role;
        $data['clients'] = $clients;

        // dd($data);

        return view('users.index', $data);
    }


    public function create()
    {
        return view('users.index');
    }
    


    public function store(User $user)
    {
        
        
        User::create([
            'name' => $user->name ,
            'email' => $user->email ,
            'password' => $user->password ,
        ]);
        return redirect()->route('users.index')->with('success','User has been added!');
    }

    public function insert_user(Request $request) {
        try {

            $data = array(
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => $request->get('password'),
                'user_role_id' => $request->get('user_role_id')
            );

            if($request->get('user_role_id') == 1) {
                $data = array(
                    'name' => $request->get('name'),
                    'email' => $request->get('email'),
                    'password' => $request->get('password'),
                    'user_role_id' => $request->get('user_role_id'),
                    'clients_id' => $request->get('clients_id')
                );
            }

            $create = config('client_be')->request('POST', '/api/user', [
                'headers' => [
                    'Accept' => 'application/json'
                ],
                'exceptions' => false,
                'json' => $data
            ]);

            if($create) {
                return redirect()->back()->with('data', 'Berhasil menambah data user');
            } else {
                return redirect()->back()->with('fail', 'Terjadi Kesalahan Sistem, Silahkan Coba Lagi');
            }

        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function update_user(Request $request) {
        try {
            $data = array(
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'user_role_id' => $request->get('user_role_id')
            );

            if($request->get('user_role_id') == 1) {
                $data = array(
                    'name' => $request->get('name'),
                    'email' => $request->get('email'),
                    'user_role_id' => $request->get('user_role_id'),
                    'clients_id' => $request->get('clients_id')
                );
            }

            $userid = $request->query('id');

            $create = config('client_be')->request('PUT', '/api/user/'.$userid, [
                'headers' => [
                    'Accept' => 'application/json'
                ],
                'exceptions' => false,
                'json' => $data
            ]);

            if($create) {
                return redirect()->back()->with('data', 'Berhasil update data user');
            } else {
                return redirect()->back()->with('fail', 'Terjadi Kesalahan Sistem, Silahkan Coba Lagi');
            }

        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function delete_user(Request $request) {
        try {

            $id = $request->query('id');

            $deleted = config('client_be')->request('DELETE', '/api/user/'.$id, [
                'headers' => [
                    'Accept' => 'application/json'
                ],
                'exceptions' => false
            ]);

            if($deleted) {
                return redirect()->back()->with('data', 'Berhasil menghapus data user');
            } else {
                return redirect()->back()->with('fail', 'Terjadi Kesalahan Sistem, Silahkan Coba Lagi');
            }

        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function checked_user(Request $request) {
        try {

            $id = $request->query('id');

            // dd($id);

            $checked = config('client_be')->request('GET', '/api/user/'.$id, [
                'headers' => [
                    'Accept' => 'application/json'
                ],
                'exceptions' => false
            ]);

            // dd($checked);

            $tobeconvert= (string) $checked->getBody();
            $data = json_decode($tobeconvert, true);

            return $data;

        } catch (\Exception $e) {
            dd($e);
        }
    }

    

}