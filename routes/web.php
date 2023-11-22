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
//usuarios//
Route::post('/usuarios/agregarusuario',[App\Http\Controllers\UsuarioController::class, 'agregarusuario']);
Route::post('/usuarios/buscarusuario',[App\Http\Controllers\UsuarioController::class, 'validarusuario']);
//pacientes//
Route::get('/pacientes/buscarpacientes',[App\Http\Controllers\PacienteController::class, 'listarPacientes']);
Route::post('/pacientes/agregarpaciente',[App\Http\Controllers\PacienteController::class, 'agregarpaciente']);
Route::post('/pacientes/actualizarpaciente/{id}',[App\Http\Controllers\PacienteController::class, 'actualizarpaciente']);
Route::post('/pacientes/eliminarpaciente/{id}', [App\Http\Controllers\PacienteController::class, 'eliminarpaciente']);
//doctores//
Route::get('/doctor/buscarespecialidad',[App\Http\Controllers\DoctorController::class, 'buscarespecialidad']);
Route::get('/doctor/buscardoctor',[App\Http\Controllers\DoctorController::class, 'listardoctores']);
Route::post('/doctor/agregardoctor',[App\Http\Controllers\DoctorController::class, 'agregardoctor']);
Route::post('/doctor/eliminardoctor/{id}', [App\Http\Controllers\DoctorController::class, 'eliminardoctor']);
Route::post('/doctor/actualizardoctor/{id}', [App\Http\Controllers\DoctorController::class, 'actualizardoctor']);
//Horarios//
Route::get('/doctor/buscarhorarios',[App\Http\Controllers\DoctorController::class, 'buscarhorarios']);
Route::post('/doctor/agregarhorario_doctor',[App\Http\Controllers\DoctorController::class, 'agregarhorario_doctor']);
Route::post('/doctor/agregarhorario', [App\Http\Controllers\DoctorController::class, 'agregarhorario']);
Route::post('/doctor/actualizarhorario/{id}', [App\Http\Controllers\DoctorController::class, 'actualizarhorario']);
Route::delete('/doctor/eliminarhorario/{id}', [App\Http\Controllers\DoctorController::class, 'eliminarhorario']);
//Departamentos //
Route::get('/departamento/buscardepartamento',[App\Http\Controllers\DepartamentoController::class, 'listardepartamento']);
Route::post('/departamento/agregardepartamento',[App\Http\Controllers\DepartamentoController::class, 'agregardepartamento']);
Route::post('/departamento/actualizardepartamento/{id}',[App\Http\Controllers\DepartamentoController::class, 'actualizardepartamento']);
Route::post('/departamento/eliminardepartamento/{id}', [App\Http\Controllers\DepartamentoController::class, 'eliminardepartamento']);
//Citas//
Route::get('/citas/buscarcitas',[App\Http\Controllers\CitaController::class, 'buscarcitas']);
Route::post('/citas/agregarcitas',[App\Http\Controllers\CitaController::class, 'agregarcitas']);
Route::post('/citas/actualizarcitas/{id}',[App\Http\Controllers\CitaController::class, 'actualizarcitas']); //data,id
Route::delete('/citas/eliminarcitas/{id}', [App\Http\Controllers\CitaController::class, 'eliminarcitas']);

//
Route::middleware(['web'])->group(function () {
Route::post('/api/pacientes/agregarpaciente', [App\Http\Controllers\PacienteController::class,'agregarpaciente']);
Route::delete('/api/pacientes/eliminar/{id}', [App\Http\Controllers\PacienteController::class, 'eliminar']);
Route::post('/api/pacientes/editarpaciente/{id}', [App\Http\Controllers\PacienteController::class, 'update']);
Route::post('/api/user/', [App\Http\Controllers\Loginauth::class, 'validateuser']);

});