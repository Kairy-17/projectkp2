<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TeamMemberController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::resource('projects', ProjectController::class);
Route::resource('reports', ReportController::class);
Route::resource('team-members', TeamMemberController::class)->except(['show']);
