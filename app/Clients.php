<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clients extends Model
{
    protected $fillable = [

        'id',
        'client_name',
        'created_at',
        'updated_at'
        

    ];
}
