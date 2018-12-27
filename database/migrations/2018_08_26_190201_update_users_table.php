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
        $key = config('auth.key');

        // 1. Add columns and simple indexes.

        // Note: We set default = '' to avoid the following error that occurs with SQLite and Laravel 5.6:
        // "Cannot add a NOT NULL column with default value NULL"
        $driver = Schema::connection($this->getConnection())->getConnection()->getDriverName();

        Schema::table('users', function (Blueprint $table) use ($driver, $key) {
            /** @noinspection PhpUndefinedMethodInspection */
            if (!Schema::hasColumn('users', 'email_verified_at')) { // should exist since Laravel 5.7 by default
                /** @noinspection PhpUndefinedMethodInspection */
                $table->timestamp('email_verified_at')->nullable()->after('email');
            }

            /** @noinspection PhpUndefinedMethodInspection */
            if (!Schema::hasColumn('users', 'role')) {
                /** @noinspection PhpUndefinedMethodInspection */
                $table->string('role', 16)->default($driver === 'sqlite' ? '' : null)->after('password');
            }

            /** @noinspection PhpUndefinedMethodInspection */
            if (!Schema::hasColumn('users', 'api_token')) {
                /** @noinspection PhpUndefinedMethodInspection */
                $table->string('api_token', 60)->default($driver === 'sqlite' ? '' : null)->after('role');
            }

            /** @noinspection PhpUndefinedMethodInspection */
            if (!Schema::hasColumn('users', 'rate_limit')) {
                /** @noinspection PhpUndefinedMethodInspection */
                $table->integer('rate_limit')->nullable()->after('api_token');
            }

            /** @noinspection PhpUndefinedMethodInspection */
            if ($key !== 'email' && !Schema::hasColumn('users', $key)) {
                /** @noinspection PhpUndefinedMethodInspection */
                $table->string($key)->default($driver === 'sqlite' ? '' : null)->after('name');
            }
        });

        // 2. Replace empty values of NOT NULL columns.

        foreach (DB::table('users')->get() as $user) {
            $data = [];

            if (empty($user->email_verified_at)) {
                $data['email_verified_at'] = empty($user->confirmation_token) ? $user->created_at : null;
            }

            if (empty($user->role)) {
                $data['role'] = config('auth.roles.0');
            }

            if (empty($user->api_token)) {
                $data['api_token'] = str_unique_random(60);
            }

            if ($user->rate_limit === null) {
                $data['rate_limit'] = config('api.rate_limit');
            }

            if ($key !== 'email' && empty($user->{$key})) {
                $data[$key] = uniqid();
            }

            if (!empty($data)) {
                DB::table('users')->where('id', '=', $user->id)->update($data);
            }
        }

        // 3. Reset the default definition and set unique indexes.

        Schema::table('users', function (Blueprint $table) use ($driver, $key) {
            // Reset default constrains.

            if ($driver === 'sqlite') {
                /** @noinspection PhpUndefinedMethodInspection */
                $table->string('role')->default(null)->change();

                /** @noinspection PhpUndefinedMethodInspection */
                $table->string('api_token')->default(null)->change();

                if ($key !== 'email') {
                    /** @noinspection PhpUndefinedMethodInspection */
                    $table->string($key)->default(null)->change();
                }
            }

            // Set unique indexes.
            // Note: We can only generate a unique index after we have generated unique values for existing records.

            /** @var \Illuminate\Database\Connection $db */
            $db = DB::connection();
            try {
                $indexes = $db->getDoctrineSchemaManager()->listTableIndexes($db->getTablePrefix() . 'users');
            }
            catch (PDOException $e) { // MSSQL 2008: Driver does not support this function: driver does not support that attribute
                $indexes = [];
            }

            if (!isset($indexes['users_api_token_unique'])) {
                $table->unique(['api_token']);
            }

            if ($key !== 'email' && !isset($indexes["users_{$key}_unique"])) {
                $table->unique([$key]);
            }
        });

        /** @noinspection PhpUndefinedMethodInspection */
        //if (Schema::hasColumn('users', 'confirmation_token')) { // obsolete column
        //    Schema::table('users', function (Blueprint $table) {
        //        $table->dropColumn('confirmation_token');
        //    });
        //}
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Bug with Laravel 5.6:
        // Multiple dropColumns() in one operation causes SQLite errors!
        // See https://github.com/laravel/framework/issues/2979

//        Schema::table('users', function (Blueprint $table) {
//            /** @noinspection PhpUndefinedMethodInspection */
//            if (Schema::hasColumn('users', 'role')) {
//                $table->dropColumn('role');
//            }
//
//            /** @noinspection PhpUndefinedMethodInspection */
//            if (Schema::hasColumn('users', 'api_token')) {
//                $table->dropColumn('api_token');
//            }
//
//            /** @noinspection PhpUndefinedMethodInspection */
//            if (Schema::hasColumn('users', 'rate_limit')) {
//                $table->dropColumn('rate_limit');
//            }
//
//            $key = config('auth.key');
//            /** @noinspection PhpUndefinedMethodInspection */
//            if ($key !== 'email' && Schema::hasColumn('users', $key)) {
//                $table->dropColumn($key);
//            }
//        });

        // Do not drop email_verified_at because it is a default column since Laravel 5.7.

        Schema::table('users', function (Blueprint $table) {
            /** @noinspection PhpUndefinedMethodInspection */
            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }
        });
        Schema::table('users', function (Blueprint $table) {
            /** @noinspection PhpUndefinedMethodInspection */
            if (Schema::hasColumn('users', 'api_token')) {
                $table->dropColumn('api_token');
            }
        });
        Schema::table('users', function (Blueprint $table) {
            /** @noinspection PhpUndefinedMethodInspection */
            if (Schema::hasColumn('users', 'rate_limit')) {
                $table->dropColumn('rate_limit');
            }
        });
        Schema::table('users', function (Blueprint $table) {
            $key = config('auth.key');
            /** @noinspection PhpUndefinedMethodInspection */
            if ($key !== 'email' && Schema::hasColumn('users', $key)) {
                $table->dropColumn($key);
            }
        });
    }
}
