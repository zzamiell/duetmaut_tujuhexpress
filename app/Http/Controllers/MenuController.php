<?php

namespace App\Http\Controllers;

use App\Clients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\RequestOptions;
use File;

class MenuController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        try {
            $data['submenu'] = DB::table('tb_menu')->select('id', 'menu_name')->where('menu_function_id', 1)->get();
            $data['reff'] = DB::table('reff_menu_function')->get();

            if ($request->get('cari')) {
                $query = $request->get('cari');

                $data['menu'] = DB::table('tb_menu')
                    ->select('tb_menu.id', 'menu_name', 'url', 'icon', 'menu_parent_id', 'menu_function_id', 'reff_menu_function.function_name')
                    ->join('reff_menu_function', 'reff_menu_function.id', '=', 'tb_menu.menu_function_id')
                    ->where('menu_name', 'LIKE', '%' . $query . '%')
                    ->paginate(10);

                return view('menu.index', $data);
            } else {
                $data['menu'] = DB::table('tb_menu')
                    ->select('tb_menu.id', 'menu_name', 'url', 'icon', 'menu_parent_id', 'menu_function_id', 'reff_menu_function.function_name')
                    ->join('reff_menu_function', 'reff_menu_function.id', '=', 'tb_menu.menu_function_id')
                    ->orderBy('id', 'DESC')
                    ->paginate(10);

                return view('menu.index', $data);
            }
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function store(Request $request)
    {
        try {

            $data = array(
                'menu_name' => $request->get('menu_name'),
                'url' => $request->get('url'),
                'icon' => $request->get('icon'),
                'menu_parent_id' => $request->get('parent'),
                'menu_function_id' => $request->get('menu_functuin'),
            );

            $insert = DB::table('tb_menu')->insert($data);

            if ($insert) {
                return redirect()->back()->with('data', 'Berhasil menambah menu');
            } else {
                return redirect()->back()->with('fail', 'Terjadi Kesalahan Sistem, Silahkan Coba Lagi');
            }

            return view('user_role.index', $data);
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function update(Request $request)
    {
        try {
            $id = (int) $request->get('id');

            $data = array(
                'menu_name' => $request->get('menu_name'),
                'url' => $request->get('url'),
                'icon' => $request->get('icon'),
                'menu_parent_id' => $request->get('parent'),
                'menu_function_id' => $request->get('menu_functuin'),
            );

            $update = DB::table('tb_menu')->where('id', $id)->update($data);

            if ($update) {
                return redirect()->back()->with('update', 'Berhasil mengubah menu');
            } else {
                return redirect()->back()->with('fail', 'Terjadi Kesalahan Sistem, Silahkan Coba Lagi');
            }
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function delete(Request $request, $id)
    {
        try {
            $hapus = DB::table('tb_menu')->where('id', $id)->delete();
        } catch (\Exception $e) {
            dd($e);
        }
    }
}
