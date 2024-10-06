<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\VoucherController;

Route::get('/voucher', function () {
    return view('voucher.voucher');
});

Route::post('/voucher/process', [VoucherController::class, 'process'])->name('voucher.process');

