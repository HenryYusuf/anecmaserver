<?php

use App\Http\Controllers\Api\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Api\Admin\DashboardController;
use App\Http\Controllers\Api\Admin\PetugasController;
use App\Http\Controllers\Api\Admin\PuskesmasController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Dashboard\JurnalMakanController;
use App\Http\Controllers\Api\Dashboard\KalkulatorController;
use App\Http\Controllers\Api\Dashboard\KonsumsiTtdController;
use App\Http\Controllers\Api\Dashboard\ReminderTtdController;
use App\Http\Controllers\Api\Profil\ProfilController;
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

    // Jurnal Makan
    Route::get('/istri/dashboard/get-jurnal-makan', [JurnalMakanController::class, 'getJurnalMakan']);
    Route::post('/istri/dashboard/jurnal-makan', [JurnalMakanController::class, 'insertJurnalMakan']);

    /*==== Admin ==== */
    // Admin Dashboard
    Route::get('/admin/dashboard-card-hitung-data', [DashboardController::class, 'hitungData']);
    Route::get('/admin/dashboard-data-terbaru', [DashboardController::class, 'dataTerbaru']);

    // Admin Data Puskesmas
    Route::get('/admin/data-puskesmas', [PuskesmasController::class, 'dataPuskesmas']);
    Route::post('/admin/data-puskesmas/insert', [PuskesmasController::class, 'insertPuskesmas']);
    Route::get('/admin/data-puskesmas/show/{id}', [PuskesmasController::class, 'showPuskesmas']);
    Route::post('/admin/data-puskesmas/update/{id}', [PuskesmasController::class, 'updatePuskesmas']);
    Route::post('/admin/data-puskesmas/delete/{id}', [PuskesmasController::class, 'deletePuskesmas']);

    // Admin Data Petugas Puskesmas
    Route::get('/admin/data-petugas-puskesmas', [PetugasController::class, 'dataPetugasPuskesmas']);
    Route::post('/admin/data-petugas-puskesmas/insert', [PetugasController::class, 'insertPetugasPuskesmas']);
    // Route::get('/admin/data-puskesmas/show/{id}', [PuskesmasController::class, 'showPuskesmas']);
    // Route::post('/admin/data-puskesmas/update/{id}', [PuskesmasController::class, 'updatePuskesmas']);
    // Route::post('/admin/data-puskesmas/delete/{id}', [PuskesmasController::class, 'deletePuskesmas']);
});