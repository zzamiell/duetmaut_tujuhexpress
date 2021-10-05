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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
