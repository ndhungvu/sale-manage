<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSomeFieldForCommodityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('commodities', function (Blueprint $table) {
            $table->integer('base_price')->after('description');
            $table->integer('cost')->after('base_price');
            $table->integer('on_hand')->after('cost');
            $table->tinyInteger('allows_sale')->after('on_hand');
            $table->integer('min_quantity')->after('allows_sale');
            $table->integer('max_quantity')->after('min_quantity');
            $table->text('order_template')->after('description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
