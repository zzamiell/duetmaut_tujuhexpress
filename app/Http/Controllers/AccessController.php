<?php

namespace App\Http\Controllers;

use App\Clients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\RequestOptions;
use File;

class AccessController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id)
    {
        try {
            $data['simenu'] = DB::table('tb_menu')->select('id', 'menu_name')->where('menu_function_id', 1)->get();
            $data['component'] = DB::table('tb_menu')->select('id', 'menu_name')->where('menu_function_id', 2)->get();
            $data['reff'] = DB::table('reff_menu_function')->get();

            $data['access'] = DB::table('tb_user_access_menu')
                ->select('tb_user_access_menu.id', 'user_role_id', 'tb_menu.menu_name', 'menu_id', 'created_at', 'created_by', 'tb_menu.menu_function_id', 'reff_menu_function.function_name')
                ->join('tb_menu', 'tb_menu.id', '=', 'tb_user_access_menu.menu_id')
                ->join('reff_menu_function', 'reff_menu_function.id', '=', 'tb_menu.menu_function_id')
                ->orderBy('id', 'DESC')
                ->where('user_role_id', $id)->get();

            return view('user_access.index', $data);
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function store(Request $request)
    {
        try {

            if ($request->get('menu') == null && $request->get('component') != null) {
                $menu = $request->get('component');
            } elseif ($request->get('menu') != null && $request->get('component') == null) {
                $menu = $request->get('menu');
            }

            $data = array(
                'user_role_id' => $request->get('role'),
                'menu_id' => $menu,
                'created_by' => session('user_real_name')
            );

            $insert = DB::table('tb_user_access_menu')->insert($data);

            if ($insert) {
                return redirect()->back()->with('data', 'Berhasil menambah access');
            } else {
                return redirect()->back()->with('fail', 'Terjadi Kesalahan Sistem, Silahkan Coba Lagi');
            }

            return view('user_role.index', $data);
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $hapus = DB::table('tb_user_access_menu')->where('id', $id)->delete();
        } catch (\Exception $e) {
            dd($e);
        }
    }
}
