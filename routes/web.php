<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['web'])->group(function () {
    /** @noinspection PhpUndefinedMethodInspection */
    if (!Route::has('package-skeleton.index')) {
        Route::any('package-skeleton', '\FRohlfing\PackageSkeleton\Http\Controllers\PackageSkeletonController@index')->name('package-skeleton.index');
    }
});
