<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommoditiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commodities', function (Blueprint $table) {
            $table->increments('id');           
            $table->string('name',255);
            $table->string('code',255);
            $table->text('description')->nullable();
            $table->integer('sell')->default(0);            
            $table->integer('buy')->default(0);
            $table->integer('sale')->default(0);
            $table->integer('number')->default(0);
            $table->string('dvt',32)->nullable();
            $table->integer('company_id');
            $table->integer('commodity_group_id');                
            $table->tinyInteger('status')->nullable();
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
        Schema::drop('commodities');
    }
}
