<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PhihxCreateTableStockTakes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stock_takes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('company_id')->default(0);
            $table->integer('branch_id')->default(0);
            $table->string('code',255);
            $table->timestamp('balance_date')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->integer('user_id')->default(0);
            $table->integer('balancer_id')->default(0);
            $table->text('note')->nullable();
            $table->integer('quantum')->default(0);
            $table->integer('quantum_diff')->default(0);
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
        Schema::drop('stock_takes');
    }
}
