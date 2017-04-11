<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PhihxCreateTablePurchaseReturns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_returns', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code',255);
            $table->timestamp('return_date')->nullable();
            $table->integer('company_id')->default(0);
            $table->integer('supplier_id')->nullable();
            $table->integer('branch_id')->default(0);
            $table->integer('user_id')->default(0);
            $table->text('note')->nullable();
            $table->integer('quantum')->default(0);
            $table->integer('amount_money')->default(0);
            $table->integer('total_money')->default(0);
            $table->integer('payed_money')->default(0);
            $table->tinyInteger('sale_type')->default(0);
            $table->tinyInteger('status')->default(0);
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
        Schema::drop('purchase_returns');
    }
}
