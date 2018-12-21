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

        Schema::table('users', function (Blueprint $table) use ($key) {
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

            /** @noinspection PhpUndefinedMethodInspection */
            if ($key !== 'email' && !Schema::hasColumn('users', $key)) {
                /** @noinspection PhpUndefinedMethodInspection */
                $table->string($key)->after('name');
            }
        });

        // 2. Set default values for NOT NULL columns.

        foreach (DB::table('users')->get() as $user) {
            $data = [];

            if (empty($user->role)) {
                $data['role'] = config('auth.roles.0');
            }

            if (empty($user->api_token)) {
                $data['api_token'] = str_unique_random(60);
            }

            //if ($user->rate_limit === null) {
            //    $data['rate_limit'] = config('api.rate_limit');
            //}

            if ($key !== 'email' && empty($user->{$key})) {
                $data[$key] = uniqid();
            }

            if (!empty($data)) {
                DB::table('users')->where('id', '=', $user->id)->update($data);
            }
        }

        // 3. Set unique indexes.
        // Note: We can only generate a unique index after we have generated unique values for existing records.

        Schema::table('users', function (Blueprint $table) use ($key) {
            /** @var \Illuminate\Database\Connection $db */
            $db = DB::connection();
            $t = $table->getTable(); // todo mit table-prefix testen
            $indexes = $db->getDoctrineSchemaManager()->listTableIndexes($t);

            if (!isset($indexes["{$t}_api_token_unique"])) {
                $table->unique(['api_token']);
            }

            if ($key !== 'email' && !isset($indexes["{$t}_{$key}_unique"])) {
                $table->unique([$key]);
            }
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
            /** @noinspection PhpUndefinedMethodInspection */
            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }

            /** @noinspection PhpUndefinedMethodInspection */
            if (Schema::hasColumn('users', 'api_token')) {
                $table->dropColumn('api_token');
            }

            /** @noinspection PhpUndefinedMethodInspection */
            if (Schema::hasColumn('users', 'rate_limit')) {
                $table->dropColumn('rate_limit');
            }

            /** @noinspection PhpUndefinedMethodInspection */
            if (Schema::hasColumn('users', 'confirmation_token')) {
                $table->dropColumn('confirmation_token');
            }

            $key = config('auth.key');
            /** @noinspection PhpUndefinedMethodInspection */
            if ($key !== 'email' && Schema::hasColumn('users', $key)) {
                $table->dropColumn($key);
            }
        });
    }
}
