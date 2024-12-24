<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExcelController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/excel', [ExcelController::class, 'index']);
Route::get('/excel/direct', [ExcelController::class, 'excelView']);
Route::get('/excel/pdf', [ExcelController::class, 'pdfView']);
Route::get('/process-excel', [ExcelController::class, 'processExcel']);
Route::get('/convert-to-pdf', [ExcelController::class, 'convertToPdf']);
