<?php

namespace App\Http\Controllers;

use App\Clients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\RequestOptions;

class ClientsController extends Controller
{
    public function index()
    {
        // $clients =  DB::table('tb_clients')->paginate(10);
        $api_client = config('client_be')->request('GET', '/api/v1/tb-clients?page=1&max_page=10&sort_by=id&sort_method=DESC', [
            'headers' => [
                // 'Authorization' => 'Bearer ' . Session::get('token'),
                'Accept' => 'application/json'
            ],
            'exceptions' => false,
        ]);
        $clients = json_decode($api_client->getBody()->getContents(), TRUE)['data']['rows'];
        $category = DB::table('reff_client_category')->get();
        // dd($clients[0]['reff_client_category']['id']);
        return view('clients.index', compact('clients', 'category'));
    }

    public function show($id)
    {
        // $api_client = config('client_be')->request('GET', '/api/v1/tb-clients?page=1&max_page=10&sort_by=id&sort_method=DESC', [
        //     'headers' => [
        //         'Accept' => 'application/json'
        //     ],
        //     'exceptions' => false,
        // ]);
        // $clients = json_decode($api_client->getBody()->getContents(), TRUE)['data']['rows'];
        $clients =  DB::table('tb_clients')->where('id', $id)->first();
        // dd($clients);
        $category = DB::table('reff_client_category')->get();
        $area = DB::table('reff_area')->take(20)->get();
        // dd($area);
        return view('clients.show', compact('clients', 'category', 'area'));
    }

    public function insert_client(Request $request)
    {
        try {
            $data = array(
                'account_name' => $request->get('acc_name'),
                'pic_name' => $request->get('pic_name'),
                'pic_number' => $request->get('pic_number'),
                'sales_agent' => $request->get('sales_agent'),
                'cod_fee' => $request->get('cod_fee'),
                'insurance_fee' => $request->get('insurance_fee'),
                'updated_at' => null,
                'clients_category' => $request->get('clients_category'),
            );
            // dd($data);
            $create = config('client_be')->request('POST', '/api/v1/tb-clients', [
                'headers' => [
                    'Accept' => 'application/json'
                ],
                'exceptions' => false,
                'json' => $data
            ]);

            if ($create) {
                return redirect()->back()->with('data', 'Berhasil menambah client');
            } else {
                return redirect()->back()->with('fail', 'Terjadi Kesalahan Sistem, Silahkan Coba Lagi');
            }
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function update_client(Request $request, $id)
    {
        try {
            $data = array(
                'account_name' => $request->get('acc_name'),
                'pic_name' => $request->get('pic_name'),
                'pic_number' => $request->get('pic_number'),
                'sales_agent' => $request->get('sales_agent'),
                'cod_fee' => $request->get('cod_fee'),
                'insurance_fee' => $request->get('insurance_fee'),
                // 'updated_at' => null,
                'clients_category' => $request->get('clients_category'),
            );
            // dd($data);
            $create = config('client_be')->request('PUT', '/api/v1/tb-clients/' . $id, [
                'headers' => [
                    'Accept' => 'application/json'
                ],
                'exceptions' => false,
                'json' => $data
            ]);

            if ($create) {
                return redirect()->back()->with('edit', 'Berhasil mengubah data client');
            } else {
                return redirect()->back()->with('fail', 'Terjadi Kesalahan Sistem, Silahkan Coba Lagi');
            }
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function hapus_clients(Request $request, $id)
    {
        try {
            $hapus = config('client_be')->request('DELETE', '/api/v1/tb-clients/' . $id, [
                'headers' => [
                    // 'Authorization' => 'Bearer ' . Session::get('token'),
                    'Accept' => 'application/json'
                ],
                'exceptions' => false,
            ]);

            $delete = json_decode($hapus->getBody()->getContents(), TRUE);
        } catch (\Exception $e) {
            dd($e);
        }
    }
}
