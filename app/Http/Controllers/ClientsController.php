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

        $clients =  DB::table('tb_clients')->where('id', $id)->first();
        $category = DB::table('reff_client_category')->get();
        $service = DB::table('reff_service_order')->get();
        $area = DB::table('reff_area')->paginate(10);


        $data_pricing = config('client_be')->request('GET', '/api/v1/tb-pricing?page=1&max_page=10&sort_by=id&sort_method=DESC&id_client=' . $id, [
            'headers' => [
                // 'Authorization' => 'Bearer ' . Session::get('token'),
                'Accept' => 'application/json'
            ],
            'exceptions' => false,
        ]);
        $pricing = json_decode($data_pricing->getBody()->getContents(), TRUE)['data']['rows'];

        // dd($pricing);
        return view('clients.show', compact('clients', 'category', 'area', 'service', 'pricing'));
    }

    public function add_pricing($id)
    {
        // dd($id);
        $clients =  DB::table('tb_clients')->where('id', $id)->first();
        $category = DB::table('reff_client_category')->get();
        $service = DB::table('reff_service_order')->get();
        $area = DB::table('reff_area')->paginate(10);


        $data_pricing = config('client_be')->request('GET', '/api/v1/tb-pricing?page=1&max_page=10&sort_by=id&sort_method=DESC&id_client=' . $id, [
            'headers' => [
                // 'Authorization' => 'Bearer ' . Session::get('token'),
                'Accept' => 'application/json'
            ],
            'exceptions' => false,
        ]);
        $pricing = json_decode($data_pricing->getBody()->getContents(), TRUE)['data']['rows'];

        // dd($pricing);
        return view('clients.add_pricing', compact('clients', 'category', 'area', 'service', 'pricing'));
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

    public function insert_pricing(Request $request)
    {
        try {
            $data = array(
                'id_client' => (int)$request->get('id_client'),
                'id_service_order' => (int)$request->get('service_order'),
                'id_area' => (int)$request->get('id_area'),
                'pricing' => (int)$request->get('price'),
            );
            // dd($data);
            $create = config('client_be')->request('POST', '/api/v1/tb-pricing', [
                'headers' => [
                    'Accept' => 'application/json'
                ],
                'exceptions' => false,
                'json' => $data
            ]);

            if ($create) {
                return redirect()->to('clients/index/' . $request->get('id_client'))->with('price', 'Berhasil menambah pricing');
            } else {
                return redirect()->to('clients/index/' . $request->get('id_client'))->with('fail', 'Terjadi Kesalahan Sistem, Silahkan Coba Lagi');
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
