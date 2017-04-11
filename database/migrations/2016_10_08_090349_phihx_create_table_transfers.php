<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PhihxCreateTableTransfers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code',255);
            $table->timestamp('transfer_date')->nullable();
            $table->integer('company_id')->default(0);
            $table->integer('from_branch_id')->default(0);
            $table->integer('to_branch_id')->default(0);
            $table->integer('user_id')->default(0);
            $table->text('note')->nullable();
            $table->integer('quantum')->default(0);
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
        Schema::drop('transfers');
    }
}
