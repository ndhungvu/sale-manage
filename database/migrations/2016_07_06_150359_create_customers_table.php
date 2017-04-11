<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',255);
            $table->string('email');            
            $table->string('address',255)->nullable();
            $table->string('mobile',32)->nullable();
            $table->string('phone',32)->nullable();
            $table->string('cmnd',255)->nullable();        
            $table->timestamp('birthday')->nullable();
            $table->tinyInteger('gender')->default(0)->nullable();            
            $table->tinyInteger('status')->nullable()->default(0);
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
        Schema::drop('customers');
    }
}
