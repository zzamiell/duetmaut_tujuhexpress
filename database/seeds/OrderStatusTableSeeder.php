<?php


use Illuminate\Database\Seeder;
use App\OrderStatus;

class OrderStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $orderStatusRecords = [
            ['id' => 1,'name' => 'info_received','desc' =>'' ],
            ['id' => 2,'name' => 'pending','desc' =>'' ], 
            ['id' => 3,'name' => 'in_transit','desc' =>'' ], 
            ['id' => 4,'name' => 'completed','desc' =>'' ], 
            ['id' => 5,'name' => 'fail_shipper','desc' =>'' ], 
            ['id' => 6,'name' => 'fail_courier','desc' =>'' ], 
            ['id' => 7,'name' => 'fail_recipient','desc' =>'' ],
            ['id' => 8,'name' => 'fail_attempt_1','desc' =>'' ],  

        ];

        OrderStatus::insert($orderStatusRecords);
    }
}
