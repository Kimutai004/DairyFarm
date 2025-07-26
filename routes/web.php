<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CattleController;
use App\Http\Controllers\MilkProductionController;
use App\Http\Controllers\BreedingRecordController;
use App\Http\Controllers\HealthRecordController;
use App\Http\Controllers\FeedRecordController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\EmployeeController as AdminEmployeeController;
use App\Http\Controllers\Admin\CattleController as AdminCattleController;
use App\Http\Controllers\Admin\MilkProductionController as AdminMilkProductionController;
use App\Http\Controllers\Admin\VaccineController as AdminVaccineController;
use App\Http\Controllers\Admin\HealthRecordController as AdminHealthRecordController;
use App\Http\Controllers\Admin\BreedingRecordController as AdminBreedingRecordController;
use App\Http\Controllers\Admin\FeedRecordController as AdminFeedRecordController;
use App\Http\Controllers\Admin\SaleController as AdminSaleController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;

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
})->name('home');

Auth::routes();

// User/Farmer Routes (Protected by auth middleware)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Cattle Management
    Route::resource('cattle', CattleController::class);
    
    // Milk Production
    Route::resource('milk-production', MilkProductionController::class);
    
    // Breeding Records
    Route::resource('breeding-records', BreedingRecordController::class);
    
    // Health Records
    Route::resource('health-records', HealthRecordController::class);
    
    // Feed Records
    Route::resource('feed-records', FeedRecordController::class);
});

// Admin Routes (Protected by auth and admin middleware)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Employee Management
    Route::resource('employees', AdminEmployeeController::class);
    
    // Cattle Management (Admin view of all cattle)
    Route::resource('cattle', AdminCattleController::class);
    
    // Milk Production Management
    Route::resource('milk-production', AdminMilkProductionController::class);
    
    // Vaccine Management
    Route::resource('vaccines', AdminVaccineController::class);
    
    // Health Records Management
    Route::resource('health-records', AdminHealthRecordController::class);
    
    // Breeding Records Management
    Route::resource('breeding-records', AdminBreedingRecordController::class);
    
    // Feed Records Management
    Route::resource('feed-records', AdminFeedRecordController::class);
    
    // Sales Management
    Route::resource('sales', AdminSaleController::class);
    
    // Reports
    Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/milk-production', [AdminReportController::class, 'milkProductionReport'])->name('reports.milk-production');
    Route::get('/reports/breeding', [AdminReportController::class, 'breedingReport'])->name('reports.breeding');
    Route::get('/reports/health', [AdminReportController::class, 'healthReport'])->name('reports.health');
    Route::get('/reports/feed', [AdminReportController::class, 'feedReport'])->name('reports.feed');
    Route::get('/reports/sales', [AdminReportController::class, 'salesReport'])->name('reports.sales');
    Route::get('/reports/financial', [AdminReportController::class, 'financialReport'])->name('reports.financial');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
