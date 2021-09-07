<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->string('awb');
            
            $table->string('ref_id');
            $table->string('account_name');
            $table->string('service_order');
            $table->string('service_type');
            $table->string('shipper_name');
            $table->string('shipper_phone');
            $table->string('shipper_address');
            $table->string('shipper_postal_code');
            $table->string('shipper_area');
            $table->string('shipper_district');
            $table->string('recipient_name');
            $table->string('recipient_phone');
            $table->string('recipient_address');
            $table->string('recipient_postal_code');
            $table->string('recipient_area');
            $table->string('recipient_district');
            $table->string('weight');
            $table->string('value_of_goods');
            $table->string('order_status');
            $table->string('is_insured');
            $table->string('is_cod');
            $table->string('delivery_fee');
            $table->string('cod_fee');
            $table->string('insurance_fee');
            $table->string('total_fee');
            $table->timestamp('date_requested')->nullable();
            $table->timestamp('update_date')->useCurrent()->useCurrentOnUpdate();
            
            
            
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
