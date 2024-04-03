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

    Route::get('operators/{id}/edit', [\App\Http\Controllers\OperatorController::class, 'edit'])->name('operators.edit');
    Route::put('operators/{id}', [\App\Http\Controllers\OperatorController::class, 'update'])->name('operators.update');
    Route::get('operators/create', [\App\Http\Controllers\OperatorController::class, 'create'])->name('operators.create');
    Route::post('operators', [\App\Http\Controllers\OperatorController::class, 'store'])->name('operators.store');
    Route::get('operators', [\App\Http\Controllers\OperatorController::class, 'index'])->name('operators.index');
    Route::get('operators/{id}/destroy', [\App\Http\Controllers\OperatorController::class, 'destroy'])->name('operators.destroy');

    Route::get('classifications/{id}/edit', [\App\Http\Controllers\ClassificationController::class, 'edit'])->name('classifications.edit');
    Route::put('classifications/{id}', [\App\Http\Controllers\ClassificationController::class, 'update'])->name('classifications.update');
    Route::get('classifications/create', [\App\Http\Controllers\ClassificationController::class, 'create'])->name('classifications.create');
    Route::post('classifications', [\App\Http\Controllers\ClassificationController::class, 'store'])->name('classifications.store');
    Route::get('classifications', [\App\Http\Controllers\ClassificationController::class, 'index'])->name('classifications.index');
    Route::get('classifications/{id}/destroy', [\App\Http\Controllers\ClassificationController::class, 'destroy'])->name('classifications.destroy');

    Route::get('client/{uuid}/detail', [\App\Http\Controllers\ClientController::class, 'show'])->name('clients.show');
    Route::get('clients/{doc}/document', [\App\Http\Controllers\ClientController::class, 'getClientDocument'])->name('clients.document');
    Route::get('clients/{id}/edit', [\App\Http\Controllers\ClientController::class, 'edit'])->name('clients.edit');
    Route::put('clients/{id}', [\App\Http\Controllers\ClientController::class, 'update'])->name('clients.update');
    Route::get('clients/create', [\App\Http\Controllers\ClientController::class, 'create'])->name('clients.create');
    Route::post('clients', [\App\Http\Controllers\ClientController::class, 'store'])->name('clients.store');
    Route::get('clients', [\App\Http\Controllers\ClientController::class, 'index'])->name('clients.index');
    Route::get('clients/{id}/destroy', [\App\Http\Controllers\ClientController::class, 'destroy'])->name('clients.destroy');
    Route::get('clients/autocomplete', [\App\Http\Controllers\ClientController::class, 'autocomplete'])->name('clients.autocomplete');

    Route::get('order-types/{id}/edit', [\App\Http\Controllers\OrderTypeController::class, 'edit'])->name('order-types.edit');
    Route::put('order-types/{id}', [\App\Http\Controllers\OrderTypeController::class, 'update'])->name('order-types.update');
    Route::get('order-types/create', [\App\Http\Controllers\OrderTypeController::class, 'create'])->name('order-types.create');
    Route::post('order-types', [\App\Http\Controllers\OrderTypeController::class, 'store'])->name('order-types.store');
    Route::get('order-types', [\App\Http\Controllers\OrderTypeController::class, 'index'])->name('order-types.index');
    Route::get('order-types/{id}/destroy', [\App\Http\Controllers\OrderTypeController::class, 'destroy'])->name('order-types.destroy');


    Route::get('factors/{id}/edit', [\App\Http\Controllers\FactorController::class, 'edit'])->name('factors.edit');
    Route::put('factors/{id}', [\App\Http\Controllers\FactorController::class, 'update'])->name('factors.update');
    Route::get('factors/create', [\App\Http\Controllers\FactorController::class, 'create'])->name('factors.create');
    Route::post('factors', [\App\Http\Controllers\FactorController::class, 'store'])->name('factors.store');
    Route::get('factors', [\App\Http\Controllers\FactorController::class, 'index'])->name('factors.index');
    Route::get('factors/{id}/destroy', [\App\Http\Controllers\FactorController::class, 'destroy'])->name('factors.destroy');


    Route::get('products/{id}/edit', [\App\Http\Controllers\ProductController::class, 'edit'])->name('products.edit');
    Route::put('products/{id}', [\App\Http\Controllers\ProductController::class, 'update'])->name('products.update');
    Route::get('products/create', [\App\Http\Controllers\ProductController::class, 'create'])->name('products.create');
    Route::post('products', [\App\Http\Controllers\ProductController::class, 'store'])->name('products.store');
    Route::get('products', [\App\Http\Controllers\ProductController::class, 'index'])->name('products.index');
    Route::get('products/{id}/destroy', [\App\Http\Controllers\ProductController::class, 'destroy'])->name('products.destroy');


    Route::get('revenue-expenses/{id}/edit', [\App\Http\Controllers\RevenueExpenseController::class, 'edit'])->name('revenue-expenses.edit');
    Route::put('revenue-expenses/{id}', [\App\Http\Controllers\RevenueExpenseController::class, 'update'])->name('revenue-expenses.update');
    Route::get('revenue-expenses/create', [\App\Http\Controllers\RevenueExpenseController::class, 'create'])->name('revenue-expenses.create');
    Route::post('revenue-expenses', [\App\Http\Controllers\RevenueExpenseController::class, 'store'])->name('revenue-expenses.store');
    Route::get('revenue-expenses', [\App\Http\Controllers\RevenueExpenseController::class, 'index'])->name('revenue-expenses.index');
    Route::get('revenue-expenses/{id}/destroy', [\App\Http\Controllers\RevenueExpenseController::class, 'destroy'])->name('revenue-expenses.destroy');


    Route::get('accounts/{id}/edit', [\App\Http\Controllers\AccountController::class, 'edit'])->name('accounts.edit');
    Route::put('accounts/{id}', [\App\Http\Controllers\AccountController::class, 'update'])->name('accounts.update');
    Route::get('accounts/create', [\App\Http\Controllers\AccountController::class, 'create'])->name('accounts.create');
    Route::post('accounts', [\App\Http\Controllers\AccountController::class, 'store'])->name('accounts.store');
    Route::get('accounts', [\App\Http\Controllers\AccountController::class, 'index'])->name('accounts.index');
    Route::get('accounts/{id}/destroy', [\App\Http\Controllers\AccountController::class, 'destroy'])->name('accounts.destroy');
    Route::get('accounts/{id}/detail', [\App\Http\Controllers\AccountController::class, 'accountDetail'])->name('accounts.detail');

    Route::get('dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard.index');

});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', function (){
   return view('layouts.app');
});