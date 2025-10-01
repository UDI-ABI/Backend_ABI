<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\ContentFrameworkProjectController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\FormularioController;
use App\Http\Controllers\FrameworkController;
use App\Http\Controllers\InvestigationLineController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\ResearchGroupController;
use App\Http\Controllers\ThematicAreaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Rutas de autenticación básicas (login, logout, etc.)
Route::get('login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::post('logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('departments/{department}/cities', [DepartmentController::class, 'cities'])->name('departments.cities');
});

Route::middleware(['auth', 'role:research_staff'])->group(function () {
    // Registro de nuevos usuarios
    Route::get('register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);

    // Perfil
    Route::get('/perfil', [PerfilController::class, 'edit'])->name('perfil.edit');
    Route::put('/perfil', [PerfilController::class, 'update'])->name('perfil.update');

    // Departamentos y ciudades
    Route::resource('departments', DepartmentController::class);
    Route::resource('cities', CityController::class);

    // Formularios
    Route::resource('formulario', FormularioController::class);

    // Estructura académica avanzada
    Route::resource('research-groups', ResearchGroupController::class);
    Route::resource('programs', ProgramController::class);
    Route::resource('investigation-lines', InvestigationLineController::class);
    Route::resource('thematic-areas', ThematicAreaController::class);

    // Frameworks
    Route::resource('frameworks', FrameworkController::class);
    Route::resource('content-framework-projects', ContentFrameworkProjectController::class);
});