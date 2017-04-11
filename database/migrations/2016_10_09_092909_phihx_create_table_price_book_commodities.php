<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PhihxCreateTablePriceBookCommodities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('price_book_commodities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('price_book_id')->nullable();
            $table->integer('commodity_id')->nullable();
            $table->integer('company_id')->nullable();
            $table->integer('base_book_price')->default(0);
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
        Schema::drop('price_book_commodities');
    }
}
