<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAstocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('astocks', function (Blueprint $table) {
            $table->id();
            $table->string('product_id');
            $table->string('order_id');
            $table->string('color_id');
            $table->string('size_id');
            $table->string('image')->nullable();
            $table->string('stock');
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
        Schema::dropIfExists('astocks');
    }
}
