<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class VundhAddSaleDateToBillSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bill_sales', function (Blueprint $table) {
            $table->timestamp('sale_date')->nullable()->after('status');
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
            $table->timestamp('sale_date')->nullable()->after('status');
        });
    }
}
