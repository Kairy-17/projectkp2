<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TeamMemberController;
use App\Http\Controllers\ReportPinController;

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');
Route::resource('projects', ProjectController::class);
Route::resource('team-members', TeamMemberController::class)->except(['show']);

Route::get('/report-pin', [ReportPinController::class, 'show'])->name('report.pin.show');
Route::post('/report-pin', [ReportPinController::class, 'verify'])->name('report.pin.verify');

Route::middleware([\App\Http\Middleware\CheckReportPin::class])->group(function () {
    Route::resource('reports', ReportController::class);
});
