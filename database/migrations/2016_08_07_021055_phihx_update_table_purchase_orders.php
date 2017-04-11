<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PhihxUpdateTablePurchaseOrders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::drop('bill_imports');
        Schema::table('purchase_orders', function (Blueprint $table) {
            $table->integer('company_id')->default(0);
            $table->integer('supplier_id')->nullable();
            $table->integer('branch_id')->default(0);
            $table->integer('user_id')->default(0);
            $table->text('note')->nullable();
            $table->integer('quantum')->default(0);
            $table->integer('amount_money')->default(0);
            $table->integer('sale')->default(0);
            $table->integer('total_money')->default(0);
            $table->integer('payed_money')->default(0);
            $table->tinyInteger('sale_type')->default(0);
            $table->tinyInteger('status')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('purchase_orders', function (Blueprint $table) {
            //
        });
    }
}
