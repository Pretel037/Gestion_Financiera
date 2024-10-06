<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\CreateTokenController;
use App\Http\Controllers\plugins\ProcesoController;
Route::get('/voucher', function () {
    return view('voucher.voucher');
});

Route::post('/voucher/process', [VoucherController::class, 'process'])->name('voucher.process');
Route::post('/process-payment', [PaymentController::class, 'processPayment']);
Route::post('/create-token', [TokenController::class, 'createToken'])->name('create.token'); // Ruta para crear el token
Route::post('/create-token', [CreateTokenController::class, 'createToken'])->name('create.token');

Route::get('/pagos', function () {
    return view('pagos');
});

Route::get('/payment', function () {
    return view('payment');
});

Route::get('/index', function () {
    return view('index');
});

Route::post('/proceso', [ProcesoController::class, 'proceso'])->name('proceso');


use App\Http\Controllers\PagoController;

Route::post('/proceso1', [PagoController::class, 'procesarPago']);

