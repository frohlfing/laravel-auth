<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PackageSkeleton extends Migration {

    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('package_skeletons', function (Blueprint $table) {
            $table->increments('id');
			$table->string('title', 191);
			$table->text('body');
			$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('package_skeletons');
    }
}
