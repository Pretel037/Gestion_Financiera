<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TokenController; // Asegúrate de importar el controlador
use App\Http\Controllers\CreateTokenController;
Route::get('/voucher', function () {
    return view('voucher.voucher');
});

Route::post('/voucher/process', [VoucherController::class, 'process'])->name('voucher.process');
Route::post('/process-payment', [PaymentController::class, 'processPayment']);
Route::post('/create-token', [TokenController::class, 'createToken'])->name('create.token'); // Ruta para crear el token
Route::post('/create-token', [CreateTokenController::class, 'createToken'])->name('create.token');

Route::get('/payment', function () {
    return view('payment');
});

Route::get('/pago', function () {
    return view('pago');
});

Route::get('/pagos', function () {
    return view('pagos');
});


