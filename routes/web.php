<?php

use Illuminate\Support\Facades\Route;

//Auth::routes(); // s. vendor/laravel/framework/src/Illuminate/Routing/Router.php (1129), function auth()

///////////////////////////////////////////////////////////////////////
// Authentication
///////////////////////////////////////////////////////////////////////

/** @noinspection PhpUndefinedMethodInspection */
if (!Route::has('login')) {
    Route::get('login', '\FRohlfing\Auth\Http\Controllers\LoginController@showLoginForm')->name('login');
    Route::post('login', '\FRohlfing\Auth\Http\Controllers\LoginController@login');
}
/** @noinspection PhpUndefinedMethodInspection */
if (!Route::has('logout')) {
    Route::post('logout', '\FRohlfing\Auth\Http\Controllers\LoginController@logout')->name('logout');
}

///////////////////////////////////////////////////////////////////////
// Registration
///////////////////////////////////////////////////////////////////////

/** @noinspection PhpUndefinedMethodInspection */
if (!Route::has('register')) {
    Route::get('register', '\FRohlfing\Auth\Http\Controllers\RegisterController@showRegistrationForm')->name('register');
    Route::post('register', '\FRohlfing\Auth\Http\Controllers\RegisterController@register');
}

///////////////////////////////////////////////////////////////////////
// Password Reset
///////////////////////////////////////////////////////////////////////

/** @noinspection PhpUndefinedMethodInspection */
if (!Route::has('password.reset')) {
    Route::get('password/reset', '\FRohlfing\Auth\Http\Controllers\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/email', '\FRohlfing\Auth\Http\Controllers\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset/{token}', '\FRohlfing\Auth\Http\Controllers\ResetPasswordController@showResetForm')->name('password.reset');
    Route::post('password/reset', '\FRohlfing\Auth\Http\Controllers\ResetPasswordController@reset');
}

///////////////////////////////////////////////////////////////////////
// Email Verification
///////////////////////////////////////////////////////////////////////

/** @noinspection PhpUndefinedMethodInspection */
if (!Route::has('auth.verification.confirm')) {
    Route::get('auth/verification/confirm/{confirmationToken}', '\FRohlfing\Auth\Http\Controllers\VerificationController@confirm')->name('auth.verification.confirm');
}
/** @noinspection PhpUndefinedMethodInspection */
if (!Route::has('auth.verification.send')) {
    Route::middleware(['auth'])->group(function () {
        Route::get('auth/verification/send', '\FRohlfing\Auth\Http\Controllers\VerificationController@send')->name('auth.verification.send');
    });
}

///////////////////////////////////////////////////////////////////////
// Password Change
///////////////////////////////////////////////////////////////////////

/** @noinspection PhpUndefinedMethodInspection */
if (!Route::has('password.change')) {
    Route::middleware(['auth'])->group(function () {
        Route::get('auth/password/change', '\FRohlfing\Auth\Http\Controllers\ChangePasswordController@showChangeForm')->name('password.change');
        Route::post('auth/password/change', '\FRohlfing\Auth\Http\Controllers\ChangePasswordController@change');
    });
}

///////////////////////////////////////////////////////////////////////
// User Profile
///////////////////////////////////////////////////////////////////////

/** @noinspection PhpUndefinedMethodInspection */
if (!Route::has('profile.index')) {
    Route::middleware(['auth'])->group(function () {
        Route::get('profile', '\FRohlfing\Auth\Http\Controllers\ProfileController@index')->name('profile.index');
        Route::get('profile/edit', '\FRohlfing\Auth\Http\Controllers\ProfileController@edit')->name('profile.edit');
        Route::patch('profile/update', '\FRohlfing\Auth\Http\Controllers\ProfileController@update')->name('profile.update');
        Route::patch('profile/api-token', '\FRohlfing\Auth\Http\Controllers\ProfileController@renewApiToken')->name('profile.api-token.renew');
    });
}

///////////////////////////////////////////////////////////////////////
// User Management
///////////////////////////////////////////////////////////////////////

/** @noinspection PhpUndefinedMethodInspection */
if (!Route::has('admin.users.index')) {
    Route::middleware(['can:manage-users'])->group(function () {
        Route::get('admin/users/{user}/replicate', '\FRohlfing\Auth\Http\Controllers\ManagementController@replicate')->name('admin.users.replicate');
        Route::patch('admin/users/{user}/confirm', '\FRohlfing\Auth\Http\Controllers\ManagementController@confirm')->name('admin.users.confirm');
        Route::resource('admin/users', '\FRohlfing\Auth\Http\Controllers\ManagementController', ['as' => 'admin']);
    });
}