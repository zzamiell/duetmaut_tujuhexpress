<?php

namespace App\Http\Controllers;

use App\Clients;
use Illuminate\Http\Request;

class ClientsController extends Controller
{
    public function index()
    {
        $clients = Clients::paginate(50);
        //dd($orders);
        return view('clients.index', compact('clients','clients'));
    }
}
