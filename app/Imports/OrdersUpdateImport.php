<?php

namespace App\Imports;

use App\orders;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithUpserts;

class OrdersUpdateImport implements ToModel,WithUpserts,WithHeadingRow
{
            public function model(array $row)
            {
                return new Orders([
                    'awb' => $row['awb'],
                    'order_status' => $row['order_status'],
                ]);
            }
            
            public function batchSize(): int
            {
                return 1000;
            }

            public function uniqueBy()
            {
                return 'awb';
            }
}

