<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('mdm/callback', \App\Http\Controllers\MDMController::class);

Route::get('enrollment', [\App\Http\Controllers\DeviceController::class, 'enrollmentPage'])->name('device.enrollment-page');
Route::post('enrollment', [\App\Http\Controllers\DeviceController::class, 'enrollment']);
