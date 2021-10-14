<?php

namespace App\Http\Controllers;

use App\Exports\OrdersExport;
use App\Imports\OrdersImport;
use App\Imports\OrdersUpdateImport;
use App\orders;
use App\OrderStatus;
use Config;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Redirect;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\OrdersLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Session;
use GuzzleHttp\Exception\BadResponseException;

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $orders = orders::all();
        // $orders = \DB::select("SELECT * FROM orders");
        // dd($request->all());

        // dd(Session::get('client_account_name'));
        // dd(Session::get('user_role_id') == 1);

        $param=$this->getData($request);
        // dd($param['data']['rows']);
        // dd($orders[0]);

        return view('orders.index', $param);
        
    }

    public function getData($request) {
        $tanggal_awal=0;
        $tanggal_akhir=0;
        $role_id=Session::get('user_role_id');
        $cari=$request->get('cari');
        $max_page=10;
        $page=1;

        if($request->get('max_page')) {
            $max_page=$request->get('max_page');
            $param['max_page']=$max_page;
        }
        else {
            $param['max_page']=$max_page;
        }

        if($request->get('page')) {
            $page=$request->get('page');
            $param['page']=$page;
        }

        else {
            $param['page']=$page;
        }

        $url = "/api/v1/orders?sort_by=id&sort_method=DESC&page=".$page."&max_page=".$max_page;

        $counter = 1;
        if($request->get('tanggal_awal') != null) {
            
            $tanggal_awal=$request->get('tanggal_awal');

            if($counter > 0) {
            $url = $url."&";
            } 
            $url = $url."startingdate=".date("Y-m-d", strtotime($tanggal_awal));
            $counter += 1;
        }

        if($request->get('tanggal_akhir') != null) {
            
            $tanggal_akhir=$request->get('tanggal_akhir');

            if($counter > 0) {
            $url = $url."&";
            } 
            $url = $url."finishingdate=".date("Y-m-d", strtotime($tanggal_akhir));
            $counter += 1;
        }

        if($tanggal_awal == 0) {  
                      
            if($counter > 0) {
            $url = $url."&";
            } 

            $dateorigin = date("Y-m-d");

            $newDate = date('Y-m-d', strtotime($dateorigin. ' - 90 days'));
            $url = $url."startingdate=".$newDate;
            $counter += 1;
            
        }

        
        if($tanggal_akhir == 0) {
            if($counter > 0) {
            $url = $url."&";
            } 
            $url = $url."finishingdate=".date("Y-m-d");
            $counter += 1;
        }

        if($role_id == 1) {
            if($counter > 0) {
                $url = $url."&";
            } 
            $url = $url."account_name=".Session::get('client_account_name');
            $counter += 1;
        }


        // hit api
        // dd($url);
        try {

            $api_client = config('client_be')->request('GET', $url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . Session::get('token'),
                    'Accept' => 'application/json'
                ],
                'exceptions' => false,
            ]);

            $data = json_decode($api_client->getBody()->getContents(), TRUE);
            
            // dd($data);

            if($data['statusCode'] == 200) {
                $param['orders']=$data['data']['rows'];
                $param['total_page']=$data['data']['total_page'];
                $param['total_data']=$data['data']['total_data'];
                $param['current_page']=$data['data']['current_page'];
            }            

            return $param;

        } catch (BadResponseException $e) {
            $response = json_decode($e->getResponse()->getBody());
            return json_encode($response);
        }


    }

    public function oldIndex(Request $request)
    {
        // $orders = orders::all();
        // $orders = \DB::select("SELECT * FROM orders");
        // dd($request->all());

        // dd(Session::get('client_account_name'));
        // dd(Session::get('user_role_id') == 1);
        $tanggal_awal = date('Y-m-d', strtotime('-3 months'));
        $tanggal_akhir = date('Y-m-d');

        if (Session::get('user_role_id') == 1) {
            if ($request->get('cari')) {
                $query = $request->get('cari');
                $orders = DB::table('orders')
                    ->where([
                        ['awb', 'LIKE', '%' . $query . '%'],
                        ['account_name', '=', Session::get('client_account_name')]
                    ])
                    ->paginate(50);
                return view('orders.index', compact('orders', 'orders'));
            } else {
                // $orders = DB::table('orders')->paginate(10);
                $tiga_bulan = \Carbon\Carbon::today()->subDays(90);

                $orders = DB::table('orders')
                    ->where([
                        ['date_requested', '>=', $tiga_bulan],
                        ['account_name', '=', Session::get('client_account_name')]
                    ])
                    ->orderBy('id', 'DESC')
                    ->paginate(50);

                $data = compact('orders', 'orders');
                $data['tanggal_awal'] = $tanggal_awal;
                $data['tanggal_akhir'] = $tanggal_akhir;
                // dd($data);
                return view('orders.index', $data);
            }
        } else {
            if ($request->get('cari')) {
                $query = $request->get('cari');
                $orders = DB::table('orders')
                    ->where('awb', 'LIKE', '%' . $query . '%')
                    ->paginate(50);
                return view('orders.index', compact('orders', 'orders'));
            } else {
                // $orders = DB::table('orders')->paginate(10);
                $tiga_bulan = \Carbon\Carbon::today()->subDays(90);
                $orders = DB::table('orders')->where('date_requested', '>=', $tiga_bulan)
                    ->orderBy('id', 'DESC')
                    ->paginate(50);

                $data = compact('orders', 'orders');
                $data['tanggal_awal'] = $tanggal_awal;
                $data['tanggal_akhir'] = $tanggal_akhir;
                // dd($data);
                return view('orders.index', $data);
            }
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function filter(Request $request)
    {

        $tanggal_awal = $request->tanggal_awal !== null ? $request->tanggal_awal : date('Y-m-d', strtotime('-3 months'));
        $tanggal_akhir = $request->tanggal_akhir !== null ? $request->tanggal_akhir : date('Y-m-d');

        if (Session::get('user_role_id') == 1) {
            if ($tanggal_awal !== null && $tanggal_akhir !== null) {
                if ($request->order_status != "all") {
                    // dd($request->tanggal_awal);
                    $orders = DB::table('orders')
                        ->where([
                            ['order_status' => $request->order_status],
                            ['account_name', '=', Session::get('client_account_name')]
                        ])
                        ->whereBetween('date_requested', [$tanggal_awal . " 00:00:00", $tanggal_akhir . " 23:59:59"])
                        ->orderBy('id', 'DESC')
                        ->paginate(10);
                } else {
                    // dd($request->tanggal_akhir);
                    // $query = "
                    // SELECT * FROM orders WHERE date_requested BETWEEN '" . $request->tanggal_awal . " 00:00:00' AND '"
                    //     . $request->tanggal_akhir . " 23:59:59'";
                    $orders = DB::table('orders')
                        ->where('account_name', '=', Session::get('client_account_name'))
                        ->whereBetween('date_requested', [$tanggal_awal . " 00:00:00", $tanggal_akhir . " 23:59:59"])
                        ->orderBy('id', 'DESC')
                        ->paginate(10);
                };
            } else {
                // $orders = DB::table('orders')->paginate(10);
                $tiga_bulan = \Carbon\Carbon::today()->subDays(90);
                $orders = DB::table('orders')
                    ->where([
                        ['date_requested', '>=', $tiga_bulan],
                        ['account_name', '=', Session::get('client_account_name')]
                    ])
                    ->orderBy('id', 'DESC')
                    ->paginate(10);

                // dd($orders);
            }
        } else {
            if ($tanggal_awal !== null && $tanggal_akhir !== null) {
                if ($request->order_status != "all") {
                    // dd($request->tanggal_awal);
                    $orders = DB::table('orders')
                        ->where([
                            'order_status' => $request->order_status,
                        ])
                        ->whereBetween('date_requested', [$tanggal_awal . " 00:00:00", $tanggal_akhir . " 23:59:59"])
                        ->orderBy('id', 'DESC')
                        ->paginate(10);
                    // $query = "
                    // SELECT * FROM orders WHERE order_status = '" . $request->order_status
                    //     . "' AND date_requested BETWEEN '" . $request->tanggal_awal . " 00:00:00' AND '"
                    //     . $request->tanggal_akhir . " 23:59:59'";
                } else {
                    // dd($request->tanggal_akhir);
                    // $query = "
                    // SELECT * FROM orders WHERE date_requested BETWEEN '" . $request->tanggal_awal . " 00:00:00' AND '"
                    //     . $request->tanggal_akhir . " 23:59:59'";
                    $orders = DB::table('orders')
                        ->whereBetween('date_requested', [$tanggal_awal . " 00:00:00", $tanggal_akhir . " 23:59:59"])
                        ->orderBy('id', 'DESC')
                        ->paginate(10);
                };
            } else {
                // $orders = DB::table('orders')->paginate(10);
                $tiga_bulan = \Carbon\Carbon::today()->subDays(90);
                $orders = DB::table('orders')->where('date_requested', '>=', $tiga_bulan)
                    ->orderBy('id', 'DESC')
                    ->paginate(10);

                // dd($orders);
            }
        }


        $data = compact('orders', 'orders');
        $data['tanggal_awal'] = $tanggal_awal;
        $data['tanggal_akhir'] = $tanggal_akhir;


        return view('orders.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['account'] = DB::table('tb_clients')->select('id', 'account_name')->get();

        // dd($data);

        return view('orders.create', $data);
    }




    public function store(Request $request)
    {
        // dd($request->all());
        $ship = explode('-', $request->get('shipper_postal_code'));
        $recipt = explode('-', $request->get('recipient_postal_code'));

        // generate id awb
        $config = [
            'table' => 'orders',
            'field' => 'awb',
            'length' => 15,
            'prefix' => 'TX-' . date('ymd')
        ];

        $awb = IdGenerator::generate($config);

        $data =  array(
            'expected_delivery_date' => $request->expected_delivery_date,
            'awb' => $awb,
            'ref_id' => $request->ref_id,
            'account_name' => $request->account_name,
            'service_order' => $request->service_order,
            'service_type' => $request->service_type,
            'shipper_name' => $request->shipper_name,
            'shipper_phone' => $request->shipper_phone,
            'shipper_address' => $request->shipper_address,
            'shipper_postal_code' => $ship[0],
            'shipper_area' => $request->shipper_area,
            'shipper_district' => $request->shipper_district,
            'recipient_name' => $request->recipient_name,
            'recipient_phone' => $request->recipient_phone,
            'recipient_address' => $request->recipient_address,
            'recipient_postal_code' => $recipt[0],
            'recipient_area' => $request->recipient_area,
            'recipient_district' => $request->recipient_district,
            'weight' => $request->weight,
            'value_of_goods' => $request->value_of_goods,
            'order_status' => 'info_received',
            'is_insured' => $request->is_insured,
            'is_cod' => $request->is_cod,
            'delivery_fee' => $request->delivery_fee,
            'cod_fee' => $request->cod_fee,
            'insurance_fee' => $request->insurance_fee,
            'total_fee' => $request->total_fee,
            'update_date' => $request->update_date,
        );

        $insert = config('client_be')->request('POST', '/api/v1/orders', [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . session('token'),
            ],
            'exceptions' => false,
            'json' => $data
        ]);

        if ($insert) {
            // $last_order = DB::table('orders')->orderBy('id', 'desc')->first();

            // $data = array(
            //     'awb' => $last_order->awb,
            //     'order_status' => $last_order->order_status,
            //     'pic' => \Auth::user()->name
            // );

            // $log = DB::table('orders_logs')->insert($data);
            return redirect()->route('orders.index')->with('success', 'Order has been added!');
        } else {
            return redirect()->route('orders.index')->with('success', 'Order has been added!');
        }
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\orders  $orders
     * @return \Illuminate\Http\Response
     */
    public function show($id, $awb)
    {
        // $orders = orders::find($id);
        // dd($awb);
        $orders = \DB::select("SELECT * FROM orders WHERE awb=:awb", ['awb' => $awb]);
        $orders = $orders[0];
        //dd($orders);
        $OrderStatus = OrderStatus::select()->get()->toArray();

        $OrdersLog = OrdersLog::where('awb', $awb)->get()->toArray();
        // dd($OrdersLog);
        // dd(compact('orders', 'OrderStatus', 'OrdersLog'));

        // dd($orders->awb);


        return view('orders.show')->with(compact('orders', 'OrderStatus', 'OrdersLog'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\orders  $orders
     * @return \Illuminate\Http\Response
     */
    public function edit(orders $orders)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\orders  $orders
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, orders $orders)
    {
        $orders->update([
            'awb' => $request->awb,
            'date_requested' => $request->date_requested,
            'ref_id' => $request->ref_id,
            'account_name' => $request->account_name,
            'service_order' => $request->service_order,
            'service_type' => $request->service_type,
            'shipper_name' => $request->shipper_name,
            'shipper_phone' => $request->shipper_phone,
            'shipper_address' => $request->shipper_address,
            'shipper_postal_code' => $request->shipper_postal_code,
            'shipper_area' => $request->shipper_area,
            'shipper_district' => $request->shipper_district,
            'recipient_name' => $request->recipient_name,
            'recipient_phone' => $request->recipient_phone,
            'recipient_address' => $request->recipient_address,
            'recipient_postal_code' => $request->recipient_postal_code,
            'recipient_area' => $request->recipient_area,
            'recipient_district' => $request->recipient_district,
            'weight' => $request->weight,
            'value_of_goods' => $request->value_of_goods,
            'order_status' => $request->order_status,
            'is_insured' => $request->is_insured,
            'is_cod' => $request->is_cod,
            'delivery_fee' => $request->delivery_fee,
            'cod_fee' => $request->cod_fee,
            'insurance_fee' => $request->insurance_fee,
            'total_fee' => $request->total_fee,
            'total_fee' => $request->total_fee,
        ]);
        $orders = orders::find($request->input('awb'));
        $orders->order_status = $request->input('order_status');
        $orders->save();

        //update order log
        $log    = new OrdersLog;
        $log->awb = $orders['awb'];
        $log->order_status = $orders['order_status'];
        $log->save();
    }

    public function update_order(Request $request, $id, orders $orders)
    {
        $data = array(
            'order_status' => $request->get('order_status')
        );

        $update = config('client_be')->request('PUT', '/api/v1/orders/' . $id, [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . session('token'),
            ],
            'exceptions' => false,
            'json' => $data
        ]);

        // $update = DB::table('orders')
        //     ->where('id', $request->get('id'))
        //     ->update($data);

        if ($update) {
            //     $check_order = DB::table('orders')
            //         ->where('id', $request->get('id'))
            //         ->first();

            //     $data = array(
            //         'awb' => $check_order->awb,
            //         'order_status' => $check_order->order_status,
            //         'pic' => \Auth::user()->name
            //     );

            //     $log = DB::table('orders_logs')->insert($data);

            return Redirect()->back()->with('success', 'Order has been edited!');
        } else {
            return Redirect()->back()->with('success', 'Order has been edited!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\orders  $orders
     * @return \Illuminate\Http\Response
     */
    public function destroy(orders $orders)
    {
        //
    }

    //export
    public function export($page, $tanggal_awal, $tanggal_akhir, $status, $account_name)
    {
        $tanggal_awal = $tanggal_awal !== null ? $tanggal_awal : date('Y-m-d');
        $tanggal_akhir = $tanggal_akhir !== null ? $tanggal_akhir : date('Y-m-d');

        ini_set('memory_limit', '-1');
        return Excel::download(new OrdersExport($page, $tanggal_awal, $tanggal_akhir, $status, $account_name), 'orders.xlsx');
        return Redirect()->route('orders.index')->with('success', 'Order has been downloaded!');
    }

    public function import(Request $request)
    {
        $request->validate([
            'import_file' => 'required'
        ]);

        Excel::import(new OrdersImport, $request->file('import_file'));

        return redirect()->route('orders.index')->with('success', 'Mass Order Uploaded');
    }

    public function importUpdate(Request $request)
    {

        $orders = Excel::toArray(new OrdersUpdateImport, $request->file('import_update_file'));

        foreach ($orders[0] as $orders) {
            orders::where('awb', $orders['awb'])->update([
                'order_status' => $orders['order_status']

            ]);
            $log    = new OrdersLog;
            $log->awb = $orders['awb'];
            $log->order_status = $orders['order_status'];
            $log->save();
        }

        $request->validate([
            'import_update_file' => 'required'
        ]);



        return redirect()->route('orders.index')->with('success', 'Mass Order Uploaded');
    }

    public function service_order_by_account($id)
    {
        $service = DB::table('tb_pricing')
            ->select('service_order')
            ->where('id_client', $id)
            ->groupBy('service_order')
            ->get();
        // dd($service);
        return json_encode($service);
    }

    public function load_postal_code($service, $id)
    {
        $zip = DB::table('tb_pricing')
            ->select('tb_pricing.id', 'id_area', 'postal_code')
            ->join('reff_area', 'reff_area.id', '=', 'tb_pricing.id_area')
            ->where('id_client', $id)
            ->where('service_order', $service)
            ->get();
        // dd($zip);
        return json_encode($zip);
    }

    public function shipper_detail($postalcode)
    {
        $detail = DB::table('reff_area')
            ->select('area_name', 'district_name')
            ->where('postal_code', $postalcode)
            ->get();

        return json_encode($detail);
    }

    public function recipt_detail($postalcode)
    {
        $detail = DB::table('reff_area')
            ->select('id', 'area_name', 'district_name')
            ->where('postal_code', $postalcode)
            ->get();

        return json_encode($detail);
    }

    public function is_cod($idclient)
    {
        $cod_fee = DB::table('tb_clients')
            ->select('cod_fee')
            ->where('id', $idclient)
            ->first();
        // dd($cod_fee);
        return json_encode($cod_fee);
    }

    public function is_insured($idclient)
    {
        $insurance_fee = DB::table('tb_clients')
            ->select('insurance_fee')
            ->where('id', $idclient)
            ->first();
        // dd($cod_fee);
        return json_encode($insurance_fee);
    }

    public function ambil_pricing($idpricing)
    {
        $pricing = DB::table('tb_pricing')
            ->select('pricing')
            ->where('id', $idpricing)
            ->first();
        // dd($cod_fee);
        return json_encode($pricing);
    }
}
