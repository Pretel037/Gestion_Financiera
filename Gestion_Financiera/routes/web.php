<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\PlinVoucherController;
use App\Http\Controllers\YapeVoucherController;
use App\Http\Controllers\RegisterControllerAuth;

use App\Http\Controllers\CulqiController_Servi_Certi;
use App\Http\Controllers\CulqiController_Servi_Certi1;

use App\Http\Controllers\RegistroVouchers;

use App\Http\Controllers\PaymentController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\CreateTokenController;
use App\Http\Controllers\ProcesoController;
use App\Http\Controllers\CulqiController;
use App\Http\Controllers\PagosSIGGAController;

use App\Http\Controllers\AuthController;


use App\Http\Controllers\VoucherValidadoController;

use App\Http\Controllers\VoucherReportController;



use App\Http\Controllers\Voucher_Controller;
use App\Http\Controllers\ReportController;

use App\Http\Controllers\ReporteCertificado;



Route::get('/', function () {
    return view('formulario');
})->name('inicio');


Route::get('/pagos1', function () {
    return view('payment-form1');
})->name('pagos1');




//registro voucher
Route::get('/voucher', function () {
    return view('voucher.voucher');
})->name('voucher');

//voucher pasado por ocr
Route::post('/voucher/process', [VoucherController::class, 'process'])->name('voucher.process');
Route::post('/voucher/processplin', [PlinVoucherController::class, 'process'])->name('voucher.processplin');

Route::post('/voucher/processyape', [YapeVoucherController::class, 'process'])->name('voucher.processyape');
Route::post('/voucher/confirm', [PlinVoucherController::class, 'confirm'])->name('voucher.confirm');

//voucher enviado correctamente
Route::get('/voucher/success', function () {
    return view('voucher.success');
})->name('voucher.success');




//pagos con culqui cursos 
Route::get('/payment', [CulqiController::class, 'showPaymentForm'])->name('payment.form');
Route::post('/process-payment', [CulqiController::class, 'processPayment'])->name('process.payment');
Route::get('/payment-success', function() { 
    return view('payment-success'); 
})->name('payment.success');
Route::get('/yape-waiting', [CulqiController::class, 'yapeWaiting'])->name('yape.waiting');


//pagos con culqui matricula 
Route::get('/payment1', [CulqiController_Servi_Certi::class, 'showPaymentForm'])->name('payment.form1');
Route::post('/process-payment1', [CulqiController_Servi_Certi::class, 'processPayment'])->name('process.payment1');

//pagos con culqui certificados 
Route::get('/payment2', [CulqiController_Servi_Certi1::class, 'showPaymentForm'])->name('payment.form2');
Route::post('/process-payment2', [CulqiController_Servi_Certi1::class, 'processPayment'])->name('process.2');













//pagos con fin





//subi execel fin

Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);


// Ruta para obtener los pagos y mostrar el reporte
// Ruta para obtener los pagos y mostrar el reporte



Route::middleware(['auth'])->group(function () {

//ruta inicio
    Route::get('/index', function () {
        return view('index');
    })->name('index');

   //ruta subir voucher plin y pagalo 
    //subi execel
    Route::get('/import', function () {
        return view('import');
    })->name('import');

    Route::post('/import', [PagosSIGGAController::class, 'importExcel'])->name('pagos.import');

   
    
    //ruta para ver registro voucher
    Route::get('/registro', [RegistroVouchers::class, 'index'])->name('registro');



    //ruta para salir 
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');


    //ruta para ver registro de banco
  


    //ruta para ver los vouchers validados
    Route::get('/vouchers', [VoucherValidadoController::class, 'index'])->name('vouchers');


    /// ruta para ver
    Route::get('/reporte', [VoucherReportController::class, 'mostrarReporte'])->name('mostrarReporte');
    Route::post('/descargar-pdf', [VoucherReportController::class, 'descargarPDF'])->name('descargarPDF');

    // registrar usuarios
    Route::get('register', [RegisterControllerAuth::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterControllerAuth::class, 'register']);
    
    Route::get('/validaciones', [Voucher_Controller::class, 'index'])->name('validaciones.index');
Route::get('/buscar-voucher', [Voucher_Controller::class, 'buscarVoucher'])->name('buscar.voucher');
Route::post('/validar-voucher', [Voucher_Controller::class, 'validarVoucher'])->name('validar.voucher');



    // reportes de cursos balance
    Route::get('/reportes/pagos', [ReportController::class, 'obtenerPagos'])->name('reportes.obtenerPagos');
    // Ruta para generar el PDF
    Route::get('/reportes/pagos/pdf', [ReportController::class, 'generarPDF'])->name('reportes.generarPDF');

    // reportes de cursos balance
    Route::get('/reportes/pagoscerti', [ReporteCertificado::class, 'obtenerPagos'])->name('reportes.obtenerPagos1');
    // Ruta para generar el PDF
    Route::get('/reportes/pagoscerti/pdf', [ReporteCertificado::class, 'generarPDF'])->name('reportes.generarPDF1');


    



});
