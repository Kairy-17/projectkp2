<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TeamMemberController;
use App\Http\Controllers\ReportPinController;
use App\Http\Controllers\MasterDataController;
use App\Http\Controllers\DashboardController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::resource('projects', ProjectController::class);
Route::resource('team-members', TeamMemberController::class);

// Master Data
Route::get('master-data', [MasterDataController::class, 'index'])->name('master-data.index');
Route::post('master-data/industri', [MasterDataController::class, 'storeIndustri'])->name('master-data.industri.store');
Route::delete('master-data/industri/{industri}', [MasterDataController::class, 'destroyIndustri'])->name('master-data.industri.destroy');
Route::post('master-data/jenis-perusahaan', [MasterDataController::class, 'storeJenisPerusahaan'])->name('master-data.jenis-perusahaan.store');
Route::delete('master-data/jenis-perusahaan/{jenisPerusahaan}', [MasterDataController::class, 'destroyJenisPerusahaan'])->name('master-data.jenis-perusahaan.destroy');

Route::get('/report-pin', [ReportPinController::class, 'show'])->name('report.pin.show');
Route::post('/report-pin', [ReportPinController::class, 'verify'])->name('report.pin.verify');

Route::middleware([\App\Http\Middleware\CheckReportPin::class])->group(function () {
    Route::resource('reports', ReportController::class);
});
