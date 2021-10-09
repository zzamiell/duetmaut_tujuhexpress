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
        $tanggal_awal = date('Y-m-d', strtotime('-3 months'));
        $tanggal_akhir = date('Y-m-d');

        if(Session::get('user_role_id') == 1) {
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

        if(Session::get('user_role_id') == 1) {
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
        // dd($ship);
        $insert =  orders::create([
            'awb' => $request->awb,
            // 'date_requested' => $request->date_requested,
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
            'order_status' => $request->order_status,
            'is_insured' => $request->is_insured,
            'is_cod' => $request->is_cod,
            'delivery_fee' => $request->delivery_fee,
            'cod_fee' => $request->cod_fee,
            'insurance_fee' => $request->insurance_fee,
            'total_fee' => $request->total_fee,
            'update_date' => $request->update_date,
        ]);

        if ($insert) {
            $last_order = DB::table('orders')->orderBy('id', 'desc')->first();

            $data = array(
                'awb' => $last_order->awb,
                'order_status' => $last_order->order_status,
                'pic' => \Auth::user()->name
            );

            $log = DB::table('orders_logs')->insert($data);
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
        // dd('masuk');
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

        $update = DB::table('orders')
            ->where('id', $request->get('id'))
            ->update($data);

        if ($update) {
            $check_order = DB::table('orders')
                ->where('id', $request->get('id'))
                ->first();

            $data = array(
                'awb' => $check_order->awb,
                'order_status' => $check_order->order_status,
                'pic' => \Auth::user()->name
            );

            $log = DB::table('orders_logs')->insert($data);

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
    public function export($page, $tgl_awal, $tgl_akhir, $status)
    {
        $tanggal_awal = $tgl_awal !== null ? $tgl_awal : date('Y-m-d');
        $tanggal_akhir = $tgl_akhir !== null ? $tgl_akhir : date('Y-m-d');

        ini_set('memory_limit', '-1');
        return Excel::download(new OrdersExport($page, $tanggal_awal, $tanggal_akhir, $status), 'orders.xlsx');
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
