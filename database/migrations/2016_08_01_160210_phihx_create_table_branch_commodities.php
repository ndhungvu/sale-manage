<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PhihxCreateTableBranchCommodities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop('branch_commodities');
        Schema::create('branch_commodities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('branch_id');
            $table->integer('commodity_id');
            $table->integer('on_hand');
            $table->integer('company_id');
            $table->timestamps();
            $table->softDeletes();
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
