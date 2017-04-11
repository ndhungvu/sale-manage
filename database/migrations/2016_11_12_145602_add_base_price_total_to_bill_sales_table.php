<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBasePriceTotalToBillSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bill_sales', function (Blueprint $table) {
            $table->integer('base_price_total')->default(0)->after('name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bill_sales', function (Blueprint $table) {
             $table->dropColumn(array('base_price_total'));
        });
    }
}
