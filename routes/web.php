<?php

use App\Http\Controllers\ClassesController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\PaymentsController;
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

Route::get('/', function () {
    return view('auth/login');
});

Auth::routes();
Route::group(['prefix' => 'clients'], function () {
    Route::get('/', [ClientController::class, 'index'])->name('clients.index');
    Route::get('/create', [ClientController::class, 'create'])->name('clients.create');
    Route::post('/store', [ClientController::class, 'store'])->name('clients.store');
    Route::get('/edit/{id}', [ClientController::class, 'edit'])->name('clients.edit');
    Route::post('/update', [ClientController::class, 'update'])->name('clients.update');
    Route::get('/show/{id}', [ClientController::class, 'show'])->name('clients.show');
    Route::get('/delete/{id}', [ClientController::class, 'delete'])->name('clients.delete');
});
Route::group(['prefix' => 'courses'], function () {
    Route::get('/', [CourseController::class, 'index'])->name('courses.index');
    Route::get('/create', [CourseController::class, 'create'])->name('courses.create');
    Route::post('/store', [CourseController::class, 'store'])->name('courses.store');
    Route::get('/edit/{id}', [CourseController::class, 'edit'])->name('courses.edit');
    Route::post('/update', [CourseController::class, 'update'])->name('courses.update');
    Route::get('/delete/{id}', [CourseController::class, 'delete'])->name('courses.delete');
    Route::get('/show/{id}', [CourseController::class, 'show'])->name('courses.show');
});
Route::group(['prefix' => 'payments'], function () {
    Route::get('/', [PaymentsController::class, 'index'])->name('payments.index');
    // Route::get('/delete/{id}', [PaymentsController::class, 'delete'])->name('payments.delete');
    Route::get('/paydone/{id}', [PaymentsController::class, 'makeAPayment'])->name('payments.paydone');
    Route::get('/getPrices', [PaymentsController::class, 'getPrices'])->name('payments.getPrices');
    Route::get('/client_payment/{id}', [PaymentsController::class, 'clientPayment'])->name('payments.client_payment');
    Route::get('/makeAPaymentClient', [PaymentsController::class, 'makeAPaymentFromClient'])->name('payments.makeAPaymentClient');
});
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
