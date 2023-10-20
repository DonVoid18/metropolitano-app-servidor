<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/get-csrf-token', [App\Http\Controllers\PacienteController::class, 'getCsrfToken']);


Route::get('/api/pacientes',[App\Http\Controllers\PacienteController::class, 'listarPacientes']);

Route::middleware(['web'])->group(function () {
Route::post('/api/pacientes/agregarpaciente', [App\Http\Controllers\PacienteController::class,'agregarpaciente']);
Route::delete('/api/pacientes/eliminar/{id}', [App\Http\Controllers\PacienteController::class, 'eliminar']);
Route::post('/api/pacientes/editarpaciente/{id}', [App\Http\Controllers\PacienteController::class, 'update']);
});