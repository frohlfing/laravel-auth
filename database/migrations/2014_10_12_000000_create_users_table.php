<?php

use Illuminate\Support\Facades\Schema;
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
            $table->string('name');
            //$table->string('username')->unique();
            /** @noinspection PhpUndefinedMethodInspection */
            $table->string('email')->unique();
            /** @noinspection PhpUndefinedMethodInspection */
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            //$table->string('role', 16);
            //$table->string('api_token', 60)->unique()->nullable();
            //$table->integer('rate_limit')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
