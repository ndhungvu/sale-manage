<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableBillSaleCommodities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bill_sale_commoditues', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('bill_sale_id')->nullable();
            $table->integer('commodity_id')->nullable();
            $table->integer('sale_money')->default(0);
            $table->integer('number')->default(0);
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
        Schema::drop('bill_sale_commoditues');
    }
}
