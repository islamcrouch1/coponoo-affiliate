<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_product', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id');
            $table->integer('product_type');
            $table->integer('order_id');
            $table->integer('stock_id');
            $table->double('price', 8, 2);
            $table->double('commission_for_item', 8, 2);
            $table->double('profit_for_item', 8, 2);
            $table->double('vendor_price', 8, 2);
            $table->double('total', 8, 2);
            $table->double('commission', 8, 2);
            $table->integer('stock');
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
        Schema::dropIfExists('order_product');
    }
}
