<?php

use App\Http\Controllers\Api\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Api\Admin\DashboardController;
use App\Http\Controllers\Api\Admin\PetugasController;
use App\Http\Controllers\Api\Admin\PuskesmasController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Dashboard\KalkulatorController;
use App\Http\Controllers\Api\Dashboard\KonsumsiTtdController;
use App\Http\Controllers\Api\Dashboard\ReminderTtdController;
use App\Http\Controllers\Api\Profil\ProfilController;
use App\Models\Puskesmas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Istri Login
Route::post('/istri/login-token', [AuthController::class, 'istriLoginToken']);

// Admin Register & Login
Route::post('/admin/register', [AdminAuthController::class, 'adminRegister']);
Route::post('/admin/login', [AdminAuthController::class, 'adminLogin']);

// Insert Puskesmas
Route::post('/puskesmas/insert', function (Request $request) {
    Puskesmas::create($request->all());
});


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/istri/login', [AuthController::class, 'istriLogin']);
    Route::get('/istri/get-user', [AuthController::class, 'getUser']);

    // Profil Istri
    Route::post('/istri/profil/update-data-diri', [ProfilController::class, 'dataDiri']);
    Route::post('/istri/profil/update-data-kehamilan', [ProfilController::class, 'dataKehamilan']);
    Route::post('/istri/profil/update-data-suami', [ProfilController::class, 'dataSuami']);

    // Kalkulator Anemia
    Route::post('/istri/dashboard/kalkulator-anemia', [KalkulatorController::class, 'kalkulatorAnemia']);

    // Konsumsi TTd
    Route::post('/istri/dashboard/konsumsi-ttd', [KonsumsiTtdController::class, 'konsumsiTablet']);

    // Reminder TTd
    Route::post('/istri/dashboard/reminder-ttd', [ReminderTtdController::class, 'setReminderTtd']);

    /*==== Admin ==== */
    // Admin Dashboard
    Route::get('/admin/dashboard-card-hitung-data', [DashboardController::class, 'hitungData']);
    Route::get('/admin/dashboard-data-terbaru', [DashboardController::class, 'dataTerbaru']);

    // Admin Data Puskesmas
    Route::get('/admin/data-puskesmas', [PuskesmasController::class, 'dataPuskesmas']);

    // Admin Data Petugas Puskesmas
    Route::get('/admin/data-petugas-puskesmas', [PetugasController::class, 'dataPetugasPuskesmas']);
});
