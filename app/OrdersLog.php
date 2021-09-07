<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrdersLog extends Model
{
    protected $fillable = [
       
        
        'id',
        'awb',
        'order_status'

    ];
}
