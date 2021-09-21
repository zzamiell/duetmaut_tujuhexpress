<?php

namespace App\Exports;

use App\orders;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrdersExport implements FromCollection, WithHeadings

{
    protected $page;

    function __construct($page)
    {
        $this->page = $page;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $tiga_bulan = \Carbon\Carbon::today()->subDays(90);
        return orders::select(
            'awb',
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
            'order_status',
            'is_insured',
            'is_cod',
            'delivery_fee',
            'cod_fee',
            'insurance_fee',
            'total_fee',
            'date_requested',
            'update_date',
        )->where('date_requested', '>=', $tiga_bulan)
            ->orderBy('id', 'DESC')
            ->paginate(50, ['*'], $this->page, $this->page);
    }

    public function headings(): array
    {
        return [
            'awb',
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
            'order_status',
            'is_insured',
            'is_cod',
            'delivery_fee',
            'cod_fee',
            'insurance_fee',
            'total_fee',
            'date_requested',
            'update_date'
        ];
    }
}
