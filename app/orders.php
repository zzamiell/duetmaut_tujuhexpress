<?php

namespace App;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Database\Eloquent\Model;

class orders extends Model
{

    //AWB GENERATOR//
    public static function boot()
{
    parent::boot();
    self::creating(function ($id) {
        $config=[
            'table'=>'orders',
            'field'=>'awb',
            'length'=>15, 
            'prefix'=>'TX-'.date('ymd')
        ];
        $id->awb = IdGenerator::generate($config);
    });
    parent::boot();
    self::creating(function ($query) {
        $query->order_status = $query ->order_status ?? 'info_received';
        
        
    });

}
    
    protected $fillable = [
       
        
        'awb',
        'date_requested',
        'ref_id',
        'account_name',
        'service_order',
        'service_type',
        'shipper_name',
        'shipper_phone',
        'shipper_address',
        'shipper_postal_code',
        'shipper_area',
        'shipper_district',
        'recipient_name',
        'recipient_phone',
        'recipient_address',
        'recipient_postal_code',
        'recipient_area',
        'recipient_district',
        'weight',
        'value_of_goods',
        'order_status' ,
        'is_insured',
        'is_cod',
        'update_date',
        'delivery_fee',
        'cod_fee',
        'insurance_fee',
        'total_fee',

    ];

    //protected $attributes = ['order_status'=>'pending'] ;
    protected $primaryKey = 'awb';

    public $incrementing = false;

    // In Laravel 6.0+ make sure to also set $keyType
    protected $keyType = 'string';
    


    
    const UPDATED_AT = 'update_date';
    const CREATED_AT = 'date_requested';


}
