<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionsController;
use Illuminate\Contracts\Session\Session;
use App\Http\Controllers\CollaboratorController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UsersController;

Route::get('/', function () {
    return view('auth.login'); 
});
Route::get( '/login' , [SessionsController::class, 'index'] )->name('login.index');
Route::post( '/login' , [SessionsController::class, 'session'] )->name('login.session');

Route::get( '/register' , [RegisterController::class, 'index'] )->name('register.index');
Route::post( '/register' , [RegisterController::class, 'store'] )->name('register.store');

// Route::get( '/logout' , [SessionsController::class, 'logout'] )->name('logout');

Route::middleware(['auth'])->group(function(){

    Route::get( '/logout' , [SessionsController::class, 'logout'] )->name('logout');

    Route::prefix('/dashboard')->group(function(){
        Route::get('', [DashboardController::class, 'index'])->name('dashboard');    
    });

    Route::prefix('/empresas')->group(function(){
        Route::get('', [CompanyController::class, 'index'])->name('empresas.show');
        Route::post('', [CompanyController::class, 'store'])->name('empresas.store'); 
        Route::get('/edit/{id}', [CompanyController::class, 'edit'])->name('empresas');
        Route::post('/edit/{id}', [CompanyController::class, 'update'])->name('empresas');
        Route::get('/delete/{id}', [CompanyController::class, 'delete'])->name('empresas');
        Route::post('/insertCompany', [CompanyController::class, 'insertCompany'])->name('empresas.insertCompany'); 
    });
    
    Route::prefix('/colaboradores')->group(function(){
        Route::get('', [CollaboratorController::class, 'index'])->name('colaboradores.show');
        Route::post('', [CollaboratorController::class, 'store'])->name('colaboradores');
        Route::get('/edit/{id}', [CollaboratorController::class, 'edit'])->name('colaboradores');
        Route::post('/edit/{id}', [CollaboratorController::class, 'update'])->name('colaboradores');
        Route::get('/delete/{id}',[CollaboratorController::class, 'delete'])->name('colaboradores');
        // Route::get('/buscar', [CollaboratorController::class, 'search'])->name('colaboradores.search');
    });

    Route::prefix('/usuarios')->group(function(){
        Route::get('', [UsersController::class, 'index'])->name('usuarios.show');
        Route::get('/updateRoleUser', [UsersController::class, 'updateRole'])->name('usuarios');
        Route::get('/administradores', [UsersController::class, 'usersAdmin'])->name('usuarios');
        Route::get('/usuarios', [UsersController::class, 'users'])->name('usuarios');
    });

    Route::prefix('/user')->group(function(){
        Route::get('', [UsersController::class, 'user_profile'])->name('user_profile.index');
        Route::post('/edit/{id}', [UsersController::class, 'updateUser'])->name('user_profile');
    });
    
});