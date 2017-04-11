<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBranchCommoditiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branch_commodities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('branch_id');
            $table->integer('commodity_id');
            $table->integer('sell_number');            
            $table->integer('buy_number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('branch_commodities');
    }
}
