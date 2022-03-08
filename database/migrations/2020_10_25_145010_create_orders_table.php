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
            $table->id();
            $table->string('user_id');
            $table->string('user_name');
            $table->string('address');
            $table->string('house')->nullable();
            $table->string('special_mark')->nullable();
            $table->string('notes')->nullable();
            $table->integer('country_id');
            $table->double('total_price' , 8 , 2);
            $table->double('total_commission' , 8 , 2);
            $table->double('total_profit' , 8 , 2);
            $table->integer('shipping_rate_id');
            $table->string('status');
            $table->string('client_name');
            $table->string('client_phone');
            $table->string('phone2')->nullable();
            $table->timestamps();
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
