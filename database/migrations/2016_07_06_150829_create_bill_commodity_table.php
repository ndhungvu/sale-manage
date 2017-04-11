<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillCommodityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bill_commodity', function (Blueprint $table) {
            $table->increments('id');            
            $table->integer('bill_id');
            $table->integer('commodity_id');
            $table->integer('number');
            $table->integer('price');
            $table->integer('fee');
            $table->integer('type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('bill_commodity');
    }
}
