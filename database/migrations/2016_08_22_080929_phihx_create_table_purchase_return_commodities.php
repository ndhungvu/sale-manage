<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PhihxCreateTablePurchaseReturnCommodities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_return_commodities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('purchase_return_id')->nullable();
            $table->integer('commodity_id')->nullable();
            $table->integer('company_id')->nullable();
            $table->integer('branch_id')->nullable();
            $table->integer('cost_price')->default(0);
            $table->integer('return_price')->default(0);
            $table->integer('quantum')->default(0);
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
        Schema::drop('purchase_return_commodities');
    }
}
