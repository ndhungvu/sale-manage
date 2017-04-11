<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommodityGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commodity_groups', function (Blueprint $table) {
            $table->increments('id');           
            $table->string('name',255);
            $table->text('description')->nullable();;
            $table->string('email',255);            
            $table->integer('parent_id');
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
       Schema::drop('commodity_groups');
    }
}
