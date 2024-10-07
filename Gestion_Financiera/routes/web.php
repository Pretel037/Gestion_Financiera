<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\CreateTokenController;
use App\Http\Controllers\ProcesoController;
use App\Http\Controllers\CulqiController;
use App\Http\Controllers\PagosSIGGAController;

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



Route::get('/index', function () {
    return view('index');
});






Route::get('/payment', [CulqiController::class, 'showPaymentForm'])->name('payment.form');
Route::post('/process-payment', [CulqiController::class, 'processPayment'])->name('process.payment');
Route::get('/payment-success', function() { 
    return view('payment-success'); 
})->name('payment.success');
Route::get('/yape-waiting', [CulqiController::class, 'yapeWaiting'])->name('yape.waiting');




Route::get('/import', function () {
    return view('import');
});

Route::post('/import', [PagosSIGGAController::class, 'importExcel'])->name('pagos.import');
