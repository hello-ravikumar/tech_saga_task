<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\AdminProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\LangController;
use App\Http\Controllers\TaskController;
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
    return view('welcome');
});


Route::get('/change/{lang?}', [LangController::class, 'change'])->name('changeLang');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Task routes
    Route::resource('tasks', TaskController::class);
});

require __DIR__.'/auth.php';

// Admin routes
Route::middleware('auth:admin')->name('admin.')->prefix('admin')->group(function() {
    Route::get('/dashboard',[DashboardController::class, 'index'])->name('dashboard');

    //Customer Urls
    Route::get('/customers',[CustomerController::class, 'index'])->name('customers');
    Route::get('/get-customer/{id}',[CustomerController::class, 'getCutomer'])->name('customer.get');
    Route::post('/update-customer-status/{id}',[CustomerController::class, 'updateStatus'])->name('customer.status-update');
    

});



Route::middleware('admin')->name('admin.')->prefix('admin')->group(function() {
    // Admin Dashboard urls
    Route::get('/profile', [AdminProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [AdminProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [AdminProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Task routes
    Route::resource('tasks', TaskController::class);
});

require __DIR__.'/adminAuth.php';