<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;
Route::get('/', function () {
    return view('test');
});



Route::post('/files', [FileController::class, 'store'])->name('files.store');
Route::get('getFile' , [FileController::class,'getFile']);

