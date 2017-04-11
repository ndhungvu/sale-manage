<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillImportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bill_imports', function (Blueprint $table) {
            $table->increments('id');           
            $table->string('code',32);
            $table->string('name',255);            
            $table->integer('total');
            $table->integer('company_id');
            $table->integer('branch_id');
            $table->integer('supplier_id');
            $table->integer('user_id');
            $table->text('note')->nullable();
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
        Schema::drop('bill_imports');
    }
}
