<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PhihxCreateTableStockTakeCommodities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_take_commodities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('stock_take_id')->nullable();
            $table->integer('commodity_id')->nullable();
            $table->integer('company_id')->nullable();
            $table->integer('branch_id')->nullable();
            $table->integer('on_hand')->default(0);
            $table->integer('quantum')->default(0);
            $table->integer('quantum_diff')->default(0);
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
        Schema::drop('stock_take_commodities');
    }
}
