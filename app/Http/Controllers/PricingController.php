<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PricingController extends Controller
{
    public function index()
    {
        try {
            $pricing =  DB::table('tb_pricing')->paginate(10);
            // dd($pricing);
            return view('pricing.index', compact('pricing'));
        } catch (\Exception $e) {
            dd($e);
        }
    }
}
