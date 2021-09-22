<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithHeadings;

use Illuminate\Support\Facades\DB;

class PricingExport implements FromCollection, WithHeadings

{
    protected $page;
    protected $id;

    function __construct($page, $id)
    {
        $this->page = $page;
        $this->id = $id;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return  DB::table('tb_pricing')
            ->select('tb_clients.account_name', 'tb_clients.pic_number', 'reff_service_order.service_order', 'reff_area.province_name', 'reff_area.area_name', 'reff_area.district_name', 'reff_area.sub_district_name', 'reff_area.postal_code')
            ->join('reff_area', 'reff_area.id', '=', 'tb_pricing.id_area')
            ->join('tb_clients', 'tb_clients.id', '=', 'tb_pricing.id_client')
            ->join('reff_service_order', 'reff_service_order.id', '=', 'tb_pricing.id_service_order')
            ->where('id_client', $this->id)
            ->orderBy('tb_pricing.id', 'DESC')
            ->paginate(10, ['*'], $this->page, $this->page);
        // dd($pricing);
    }

    public function headings(): array
    {
        return
            [
                'account_name',
                'pic_number',
                'service_order',
                'province_name',
                'area_name',
                'district_name',
                'sub_district_name',
                'postal_code'
            ];
    }
}
