<?php

namespace App\Imports;

use App\orders;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class OrdersImport implements ToModel,WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return orders|null
     */
    public function model(array $row)
    {
        return new orders([
            
            
            'ref_id'=> $row['ref_id'],
            'account_name'=> $row['account_name'],
            'service_order'=> $row['service_order'],
            'service_type'=> $row['service_type'],
            'shipper_name'=> $row['shipper_name'],
            'shipper_phone'=> $row['shipper_phone'],
            'shipper_address'=> $row['shipper_address'],
            'shipper_postal_code'=> $row['shipper_postal_code'],
            'shipper_area'=> $row['shipper_area'],
            'shipper_district'=> $row['shipper_district'],
            'recipient_name'=> $row['recipient_name'],
            'recipient_phone'=> $row['recipient_phone'],
            'recipient_address'=> $row['recipient_address'],
            'recipient_postal_code'=> $row['recipient_postal_code'],
            'recipient_area'=> $row['recipient_area'],
            'recipient_district'=> $row['recipient_district'],
            'weight'=> $row['weight'],
            'value_of_goods'=> $row['value_of_goods'],
            
            'is_insured'=> $row['is_insured'],
            'is_cod'=> $row['is_cod'],
            'delivery_fee'=> $row['delivery_fee'],
            'cod_fee'=> $row['cod_fee'],
            'insurance_fee'=> $row['insurance_fee'],
            'total_fee'=> $row['total_fee'],
        ]);
    }
}