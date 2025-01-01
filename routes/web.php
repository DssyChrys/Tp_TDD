<?php

use App\Http\Controllers\UeController;
use App\Http\Controllers\EcController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [UeController::class,'index']
)->name('dashboard');

Route::get('/index', [UeController::class,'index'])->name('index');
Route::get('/createUe', [UeController::class,'create'])->name('Ue.create');
Route::post('/storeUe',[UeController::class,'store'])->name('Ue.store');
Route::delete('/{id}/deleteUe',[UeController::class,'delete'])->name('Ue.delete');


Route::get('/createEc', [EcController::class,'create'])->name('Ec.create');
Route::post('/storeEc',[EcController::class,'store'])->name('Ec.store');
Route::get('/{id}/editEc',[EcController::class,'edit'])->name('Ec.edit');
Route::put('/{id}/updateEc',[EcController::class,'update'])->name('Ec.update');
Route::delete('/{id}/deleteEc',[EcController::class,'delete'])->name('Ec.delete');