<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 1. Add columns and simple indexes.

        Schema::table('users', function (Blueprint $table) {
            /** @noinspection PhpUndefinedMethodInspection */
            if (!Schema::hasColumn('users', 'username')) {
                /** @noinspection PhpUndefinedMethodInspection */
                $table->string('username')->after('name');
            }

            /** @noinspection PhpUndefinedMethodInspection */
            if (!Schema::hasColumn('users', 'role')) {
                /** @noinspection PhpUndefinedMethodInspection */
                $table->string('role', 16)->after('password');
            }

            /** @noinspection PhpUndefinedMethodInspection */
            if (!Schema::hasColumn('users', 'api_token')) {
                /** @noinspection PhpUndefinedMethodInspection */
                $table->string('api_token', 60)->after('role');
            }

            /** @noinspection PhpUndefinedMethodInspection */
            if (!Schema::hasColumn('users', 'rate_limit')) {
                /** @noinspection PhpUndefinedMethodInspection */
                $table->integer('rate_limit')->nullable()->after('api_token');
            }

            /** @noinspection PhpUndefinedMethodInspection */
            if (!Schema::hasColumn('users', 'confirmation_token')) {
                /** @noinspection PhpUndefinedMethodInspection */
                $table->string('confirmation_token', 60)->index()->nullable()->after('rate_limit');
            }
        });

        // 2. Set default values for NOT NULL columns.

        foreach (DB::table('users')->get() as $user) {
            $data = [];

            if (empty($user->username)) {
                $data['username'] = uniqid('u');
            }

            if (empty($user->role)) {
                $data['role'] = config('auth.roles.0');
            }

            if (empty($user->api_token)) {
                $data['api_token'] = str_unique_random(60);
            }

            if (!empty($data)) {
                DB::table('users')->where('id', '=', $user->id)->update($data);
            }
        }

        // 3. Set unique indexes.
        // Note: We can only generate a unique index after we have generated unique values for the existing records.

        Schema::table('users', function (Blueprint $table) {
            $table->unique(['username']);
            $table->unique(['api_token']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'username',
                'role',
                'api_token',
                'rate_limit',
                'confirmation_token',
            ]);
        });
    }
}
