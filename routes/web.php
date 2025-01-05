<?php

use App\Http\Controllers\UeController;
use App\Http\Controllers\EcController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\NoteController;

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


Route::get('/etudiants', [EtudiantController::class, 'index'])->name('etudiants.index');
Route::get('/etudiants/create', [EtudiantController::class, 'create'])->name('etudiants.create');
Route::post('/etudiants', [EtudiantController::class, 'store'])->name('etudiants.store');
Route::resource('etudiants', EtudiantController::class)->except(['index', 'create', 'store']); 

Route::get('/notes/create', [EtudiantController::class, 'createNote'])->name('notes.create');
Route::post('/notes', [NoteController::class, 'store'])->name('notes.store');
Route::get('/notes', [NoteController::class, 'index'])->name('notes.index');
Route::get('/notes/moyenne/{etudiant}', [NoteController::class, 'moyenne'])->name('notes.moyenne');
Route::get('/notes/{note}/edit', [NoteController::class, 'edit'])->name('notes.edit');
Route::delete('/notes/{note}', [NoteController::class, 'destroy'])->name('notes.destroy');
Route::put('/notes/{note}', [NoteController::class, 'update'])->name('notes.update');
