<?php

namespace App\Http\Controllers;

use App\Clients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\RequestOptions;
use File;

class RoleController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        try {

            $data['role'] = DB::table('reff_user_role')->get();

            return view('user_role.index', $data);
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function insert_role(Request $request)
    {
        try {
            $data = array(
                'user_role_name' => $request->get('role')
            );

            $insert = DB::table('reff_user_role')->insert($data);

            if ($insert) {
                return redirect()->back()->with('data', 'Berhasil menambah user role');
            } else {
                return redirect()->back()->with('fail', 'Terjadi Kesalahan Sistem, Silahkan Coba Lagi');
            }

            return view('user_role.index', $data);
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function delete_role(Request $request, $id)
    {
        try {
            $hapus = DB::table('reff_user_role')->where('id', $id)->delete();
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function update_role(Request $request)
    {
        try {
            $id = (int) $request->get('id');
            $data = array(
                'user_role_name' => $request->get('role')
            );

            $update = DB::table('reff_user_role')->where('id', $id)->update($data);

            if ($update) {
                return redirect()->back()->with('update', 'Berhasil mengubah user role');
            } else {
                return redirect()->back()->with('fail', 'Terjadi Kesalahan Sistem, Silahkan Coba Lagi');
            }
        } catch (\Exception $e) {
            dd($e);
        }
    }
}
