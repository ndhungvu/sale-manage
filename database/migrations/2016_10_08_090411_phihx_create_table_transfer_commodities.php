<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PhihxCreateTableTransferCommodities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfer_commodities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('transfer_order_id')->nullable();
            $table->integer('commodity_id')->nullable();
            $table->integer('company_id')->nullable();
            $table->integer('branch_id')->nullable();
            $table->integer('base_price')->default(0);
            $table->integer('quantum')->default(0);
            $table->integer('transfer_money')->default(0);
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
        Schema::drop('transfer_commodities');
    }
}
