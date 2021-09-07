<?php

namespace App;
use HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
        public $table = "orderstatus";
        protected $fillable = [
       
                
                'id',
                'name',
                'desc'
                
        
            ];
            
        
}
