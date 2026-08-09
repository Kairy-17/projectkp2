<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TeamMemberController;
use App\Http\Controllers\ReportPinController;
use App\Http\Controllers\MasterDataController;
use App\Http\Controllers\ReportAttachmentController;
use App\Http\Controllers\GeneralAttachmentController;
use App\Http\Controllers\AuthController;

Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::get('/lang/{locale}', function ($locale) {
    if (in_array($locale, ['id', 'en'])) {
        session(['locale' => $locale]);
    }
    return back();
})->name('lang.switch');

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', function () {
        session()->forget('report_pin_verified');
        return view('dashboard');
    })->name('dashboard');

    Route::resource('projects', ProjectController::class);
    Route::resource('team-members', TeamMemberController::class);

    // Master Data (No PIN required)
    Route::get('master-data', [MasterDataController::class, 'index'])->name('master-data.index');
    Route::post('master-data/industri', [MasterDataController::class, 'storeIndustri'])->name('master-data.industri.store');
    Route::delete('master-data/industri/{industri}', [MasterDataController::class, 'destroyIndustri'])->name('master-data.industri.destroy');
    Route::post('master-data/jenis-perusahaan', [MasterDataController::class, 'storeJenisPerusahaan'])->name('master-data.jenis-perusahaan.store');
    Route::delete('master-data/jenis-perusahaan/{jenisPerusahaan}', [MasterDataController::class, 'destroyJenisPerusahaan'])->name('master-data.jenis-perusahaan.destroy');
    Route::post('master-data/layanan', [MasterDataController::class, 'storeLayanan'])->name('master-data.layanan.store');
    Route::delete('master-data/layanan/{layanan}', [MasterDataController::class, 'destroyLayanan'])->name('master-data.layanan.destroy');

    // General Attachments (Brankas Umum - No PIN required)
    Route::get('general-attachments', [GeneralAttachmentController::class, 'index'])->name('general-attachments.index');
    Route::post('general-attachments', [GeneralAttachmentController::class, 'store'])->name('general-attachments.store');
    Route::delete('general-attachments/{general_attachment}', [GeneralAttachmentController::class, 'destroy'])->name('general-attachments.destroy');

    Route::get('/report-pin', [ReportPinController::class, 'show'])->name('report.pin.show');
    Route::post('/report-pin', [ReportPinController::class, 'verify'])->name('report.pin.verify');

    Route::middleware([\App\Http\Middleware\CheckReportPin::class])->group(function () {
        Route::resource('reports', ReportController::class);
        Route::get('reports/{report}/attachments', [ReportAttachmentController::class, 'index'])->name('reports.attachments.index');
        Route::post('report-attachments', [ReportAttachmentController::class, 'store'])->name('report-attachments.store');
        Route::delete('report-attachments/{attachment}', [ReportAttachmentController::class, 'destroy'])->name('report-attachments.destroy');
    });
});

