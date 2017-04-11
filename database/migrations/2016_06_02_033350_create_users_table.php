<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nickname',255)->unique();
            $table->string('first_names',255);
            $table->string('last_name',255);
            $table->string('email')->unique();
            $table->string('password', 64);
            $table->string('address',255)->nullable();
            $table->string('mobile',32)->nullable();
            $table->string('phone',32)->nullable();
            $table->string('cmnd',255)->nullable();        
            $table->timestamp('birthday')->nullable();
            $table->tinyInteger('gender')->default(0)->nullable();
            $table->string('avatar',255)->nullable();
            $table->tinyInteger('status')->nullable()->default(0);
            $table->string('role_id',32);
            $table->rememberToken();
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
        Schema::drop('users');
    }
}
