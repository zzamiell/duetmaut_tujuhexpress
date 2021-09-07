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

class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = orders::all();
        //dd($orders);
        
        //dd($orderStatus);
        return view('orders.index', compact('orders','orders'));
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
        
        
        orders::create([
            'awb' => $request->awb ,
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
            'update_date'=> $request->update_date,  
            
            

        ]);
        
        
        
        return redirect()->route('orders.index')->with('success','Order has been added!');
    }
    
    

    /**
     * Display the specified resource.
     *
     * @param  \App\orders  $orders
     * @return \Illuminate\Http\Response
     */
    public function show($awb)
    {
        $orders = orders::find($awb);
        $OrderStatus = OrderStatus::select()->get()->toArray();
        $OrdersLog = OrdersLog::where('awb',$awb)->get()->toArray();
        
        
        
        
        return view('orders.show')->with(compact('orders','OrderStatus','OrdersLog'));
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
        $log ->awb = $orders['awb'];
        $log->order_status = $orders['order_status'];
        $log->save();
        return Redirect()->route('orders.update',$orders->awb)->with('success','Order has been edited!');

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
        return Redirect()->route('orders.index')->with('success','Order has been downloaded!');
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
        
        foreach($orders[0] as $orders){
            orders::where('awb', $orders['awb'])->update([
                'order_status' => $orders['order_status']
                
            ]);
            $log    = new OrdersLog;
            $log ->awb = $orders['awb'];
            $log->order_status = $orders['order_status'];
            $log->save();
        }
        
        $request->validate([
            'import_update_file' => 'required'
        ]);
        
        
        
        return redirect()->route('orders.index')->with('success', 'Mass Order Uploaded');
    }

    
    

}
