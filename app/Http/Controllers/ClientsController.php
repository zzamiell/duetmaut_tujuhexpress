<?php

namespace App\Http\Controllers;

use App\Clients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\RequestOptions;
use File;
use Illuminate\Support\Collection;

use Illuminate\Container\Container;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

// export excel
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PricingExport;

class ClientsController extends Controller
{
    public function index(Request $request)
    {
        // dd($request->all());

        if (isset($request->max_page)) {
            $max_page = $request->max_page;
        } else {
            $max_page = 10;
        }

        if (isset($request->page)) {
            $page = $request->page;
        } else {
            $page = 1;
        }

        if (isset($request->cari)) {
            $cari = "&account_name=" . $request->cari;
        } else {
            $cari = null;
        }

        $api_client = config('client_be')->request('GET', '/api/v1/tb-clients?page=' . $page . '&max_page=' . $max_page . '&sort_by=id&sort_method=DESC' . $cari . '', [
            'headers' => [
                'Accept' => 'application/json'
            ],
            'exceptions' => false,
        ]);
        $clients = json_decode($api_client->getBody()->getContents(), TRUE)['data'];

        $category = DB::table('reff_client_category')->get();
        // dd($clients);
        return view('clients.index', compact('clients', 'category'));
    }

    public function importExcel(Request $request)
    {

        // $file = $request->all();
        // dd($request->file('file'));
        if ($request->hasFile('file')) {
            $file = $request->file('file');

            // Mendapatkan Nama File
            $nama_file = $file->getClientOriginalName();

            // Mendapatkan Extension File
            $extension = $file->getClientOriginalExtension();

            $file_mime = $file->getmimeType();
            $fileContent = File::get($file);

            $multipart = [
                [
                    'name'     => 'datapricing',
                    'contents' => $fileContent,
                    'filename' => $nama_file,
                    'Mime-Type' => $file_mime,
                    'extension' => $extension
                ]
            ];

            // dd($multipart);

            $data_pricing_added = config('client_be')->request('POST', '/api/v1/tb-pricing/upload', [
                'headers' => [
                    // 'Authorization' => 'Bearer ' . Session::get('token'),
                    'Accept' => 'application/json'
                ],
                'exceptions' => false,
                'multipart' => $multipart
            ]);

            $param = [];
            $param = (string) $data_pricing_added->getBody();
            $data = json_decode($param, true);

            // dd($data);
            if ($data['statusCode'] != 200) {
                return json_encode(['statusCode' => $data['statusCode'], 'message' => $data['message']]);
            } else {
                return json_encode(['statusCode' => $data['statusCode'], 'message' => $data['message']]);
            }
        }
    }

    public function show(Request $request, $id, $service)
    {
        if ($request->get('service_order')) {
            $api_client = config('client_be')->request('GET', '/api/v1/tb-clients?id=' . $id, [
                'headers' => [
                    'Accept' => 'application/json'
                ],
                'exceptions' => false,
            ]);
            $clients = json_decode($api_client->getBody()->getContents(), TRUE)['data']['rows'];
            // $clients =  DB::table('tb_clients')->where('id', $id)->first();
            $category = DB::table('reff_client_category')->get();
            $service = DB::table('reff_service_order')->get();
            $area = DB::table('reff_area')->paginate(10);

            $breadcumb = DB::table('tb_pricing')
                ->select('service_order')
                ->where('id_client', $id)
                ->groupBy('service_order')
                ->get();

            $pricing =  DB::table('tb_pricing')
                ->join('reff_area', 'reff_area.id', '=', 'tb_pricing.id_area')
                ->join('tb_clients', 'tb_clients.id', '=', 'tb_pricing.id_client')
                ->where('tb_pricing.id_client', $id)
                ->where('tb_pricing.service_order', $request->get('service_order'))
                ->orderBy('tb_pricing.id', 'DESC')
                ->paginate(10);

            return view('clients.show', compact('clients', 'category', 'area', 'service', 'pricing', 'breadcumb'));
        } else {
            $api_client = config('client_be')->request('GET', '/api/v1/tb-clients?id=' . $id, [
                'headers' => [
                    'Accept' => 'application/json'
                ],
                'exceptions' => false,
            ]);
            $clients = json_decode($api_client->getBody()->getContents(), TRUE)['data']['rows'];
            // $clients =  DB::table('tb_clients')->where('id', $id)->first();
            $category = DB::table('reff_client_category')->get();
            $service = DB::table('reff_service_order')->get();
            $area = DB::table('reff_area')->paginate(10);

            $breadcumb = DB::table('tb_pricing')
                ->select('service_order')
                ->where('id_client', $id)
                ->groupBy('service_order')
                ->get();


            $pricing =  DB::table('tb_pricing')
                ->join('reff_area', 'reff_area.id', '=', 'tb_pricing.id_area')
                ->join('tb_clients', 'tb_clients.id', '=', 'tb_pricing.id_client')
                ->where('id_client', $id)
                ->orderBy('tb_pricing.id', 'DESC')
                ->paginate(10);

            return view('clients.show', compact('clients', 'category', 'area', 'service', 'pricing', 'breadcumb'));
        }
    }

    public function exportPricing($page, $id)
    {
        ini_set('memory_limit', '-1');
        return Excel::download(new PricingExport($page, $id), 'orders.xlsx');
        return Redirect()->back()->with('export_pricing', 'Export pricing has been downloaded!');
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

        return view('clients.add_pricing', compact('clients', 'category', 'area', 'service', 'pricing'));
    }

    public function insert_client(Request $request)
    {
        try {
            $cod = str_replace('%', '', $request->get('cod_fee'));
            $insurance = str_replace('%', '', $request->get('insurance_fee'));

            $data = array(
                'account_name' => $request->get('acc_name'),
                'pic_name' => $request->get('pic_name'),
                'pic_number' => $request->get('pic_number'),
                'sales_agent' => $request->get('sales_agent'),
                'cod_fee' => (int)$cod,
                'insurance_fee' => (int)$insurance,
                'updated_at' => null,
                'clients_category' => $request->get('clients_category'),
            );

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
            // dd($request->all());
            $data = array(
                'id_client' => (int)$request->get('id_client'),
                'service_order' => $request->get('service_order'),
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
                return redirect()->to('clients/index/' . $request->get('id_client') . "/0")->with('price', 'Berhasil menambah pricing');
            } else {
                return redirect()->to('clients/index/' . $request->get('id_client') . "/0")->with('fail', 'Terjadi Kesalahan Sistem, Silahkan Coba Lagi');
            }
        } catch (\Exception $e) {
            dd($e);
        }
    }

    public function update_client(Request $request, $id)
    {
        try {
            $cod = str_replace('%', '', $request->get('cod_fee'));
            $insurance = str_replace('%', '', $request->get('insurance_fee'));
            $data = array(
                'account_name' => $request->get('acc_name'),
                'pic_name' => $request->get('pic_name'),
                'pic_number' => $request->get('pic_number'),
                'sales_agent' => $request->get('sales_agent'),
                'cod_fee' => $cod,
                'insurance_fee' => $insurance,
                'clients_category' => $request->get('clients_category'),
            );

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

class CollectionHelper
{
    public static function paginate(Collection $results, $pageSize)
    {
        $page = Paginator::resolveCurrentPage('page');

        $total = $results->count();

        return self::paginator($results->forPage($page, $pageSize), $total, $pageSize, $page, [
            'path' => Paginator::resolveCurrentPath(),
            'pageName' => 'page',
        ]);
    }

    /**
     * Create a new length-aware paginator instance.
     *
     * @param  \Illuminate\Support\Collection  $items
     * @param  int  $total
     * @param  int  $perPage
     * @param  int  $currentPage
     * @param  array  $options
     * @return \Illuminate\Pagination\LengthAwarePaginator
     */
    protected static function paginator($items, $total, $perPage, $currentPage, $options)
    {
        return Container::getInstance()->makeWith(LengthAwarePaginator::class, compact(
            'items',
            'total',
            'perPage',
            'currentPage',
            'options'
        ));
    }
}
