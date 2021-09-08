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

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $orders = orders::all();
        // dd($orders);
        $orders = \DB::select("SELECT * FROM orders");
        // dd(compact('orders', 'orders'));

        //dd($orderStatus);
        return view('orders.index', compact('orders', 'orders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {


        return view('orders.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->awb);
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
    public function show($awb)
    {
        // dd($awb);
        $orders = \DB::select("SELECT * FROM orders WHERE awb=:awb",['awb'=>$awb]);
        $orders = $orders[0];
        //dd($orders);
        $OrderStatus = OrderStatus::select()->get()->toArray();
        
        $OrdersLog = OrdersLog::where('awb', $awb)->get()->toArray();
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
            return Redirect()->route('orders.update', $id)->with('success', 'Order has been edited!');
        } else {
            return Redirect()->route('orders.update', $id)->with('success', 'Order has been edited!');
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
    public function export()
    {

        return Excel::download(new OrdersExport, 'orders.xlsx');
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
}
