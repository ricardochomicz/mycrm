<?php

use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::post('register', [RegisterController::class, 'register'])->name('register.create');

Route::group(['middleware' => 'auth', 'prefix' => 'app'], function () {

    Route::get('plans/{id}/edit', [\App\Http\Controllers\PlanController::class, 'edit'])->name('plans.edit');
    Route::put('plans/{id}', [\App\Http\Controllers\PlanController::class, 'update'])->name('plans.update');
    Route::get('plans/create', [\App\Http\Controllers\PlanController::class, 'create'])->name('plans.create');
    Route::post('plans', [\App\Http\Controllers\PlanController::class, 'store'])->name('plans.store');
    Route::get('plans', [\App\Http\Controllers\PlanController::class, 'index'])->name('plans.index');
    Route::get('plans/{id}/destroy', [\App\Http\Controllers\PlanController::class, 'destroy'])->name('plans.destroy');


    Route::get('tenants/{id}/edit', [\App\Http\Controllers\TenantController::class, 'edit'])->name('tenants.edit');
    Route::put('tenants/{id}', [\App\Http\Controllers\TenantController::class, 'update'])->name('tenants.update');
    Route::get('tenants/create', [\App\Http\Controllers\TenantController::class, 'create'])->name('tenants.create');
    Route::post('tenants', [\App\Http\Controllers\TenantController::class, 'store'])->name('tenants.store');
    Route::get('tenants', [\App\Http\Controllers\TenantController::class, 'index'])->name('tenants.index');
    Route::get('tenants/{id}/destroy', [\App\Http\Controllers\TenantController::class, 'destroy'])->name('tenants.destroy');

    Route::get('current-accounts/{id}/edit', [\App\Http\Controllers\CurrentAccountController::class, 'edit'])->name('current.accounts.edit');
    Route::put('current-accounts/{id}', [\App\Http\Controllers\CurrentAccountController::class, 'update'])->name('current.accounts.update');
    Route::get('current-accounts/create', [\App\Http\Controllers\CurrentAccountController::class, 'create'])->name('current.accounts.create');
    Route::post('current-accounts', [\App\Http\Controllers\CurrentAccountController::class, 'store'])->name('current.accounts.store');
    Route::get('current-accounts', [\App\Http\Controllers\CurrentAccountController::class, 'index'])->name('current.accounts.index');
    Route::get('current-accounts/{id}/destroy', [\App\Http\Controllers\CurrentAccountController::class, 'destroy'])->name('current.accounts.destroy');

    Route::get('providers/{id}/edit', [\App\Http\Controllers\ProviderController::class, 'edit'])->name('providers.edit');
    Route::put('providers/{id}', [\App\Http\Controllers\ProviderController::class, 'update'])->name('providers.update');
    Route::get('providers/create', [\App\Http\Controllers\ProviderController::class, 'create'])->name('providers.create');
    Route::post('providers', [\App\Http\Controllers\ProviderController::class, 'store'])->name('providers.store');
    Route::get('providers', [\App\Http\Controllers\ProviderController::class, 'index'])->name('providers.index');
    Route::get('providers/{id}/destroy', [\App\Http\Controllers\ProviderController::class, 'destroy'])->name('providers.destroy');

    Route::get('categories/{id}/edit', [\App\Http\Controllers\CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('categories/{id}', [\App\Http\Controllers\CategoryController::class, 'update'])->name('categories.update');
    Route::get('categories/create', [\App\Http\Controllers\CategoryController::class, 'create'])->name('categories.create');
    Route::post('categories', [\App\Http\Controllers\CategoryController::class, 'store'])->name('categories.store');
    Route::get('categories', [\App\Http\Controllers\CategoryController::class, 'index'])->name('categories.index');
    Route::get('categories/{id}/destroy', [\App\Http\Controllers\CategoryController::class, 'destroy'])->name('categories.destroy');

    Route::get('users/{id}/edit', [\App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
    Route::put('users/{id}', [\App\Http\Controllers\UserController::class, 'update'])->name('users.update');
    Route::get('users/create', [\App\Http\Controllers\UserController::class, 'create'])->name('users.create');
    Route::post('users', [\App\Http\Controllers\UserController::class, 'store'])->name('users.store');
    Route::get('users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');
    Route::get('users/{id}/destroy', [\App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');

    Route::get('teams/{id}/edit', [\App\Http\Controllers\TeamController::class, 'edit'])->name('teams.edit');
    Route::put('teams/{id}', [\App\Http\Controllers\TeamController::class, 'update'])->name('teams.update');
    Route::get('teams/create', [\App\Http\Controllers\TeamController::class, 'create'])->name('teams.create');
    Route::post('teams', [\App\Http\Controllers\TeamController::class, 'store'])->name('teams.store');
    Route::get('teams', [\App\Http\Controllers\TeamController::class, 'index'])->name('teams.index');
    Route::get('teams/{id}/destroy', [\App\Http\Controllers\TeamController::class, 'destroy'])->name('teams.destroy');
    Route::get('teams/{id}/members', [\App\Http\Controllers\TeamController::class, 'members'])->name('teams.members.index');
    Route::get('teams/{id}/members/edit', [\App\Http\Controllers\TeamController::class, 'editMembers'])->name('teams.members.edit');

    Route::get('dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard.index');

});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', function (){
   return view('layouts.app');
});