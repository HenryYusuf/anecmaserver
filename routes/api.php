<?php

use App\Http\Controllers\Api\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Api\Admin\DashboardController;
use App\Http\Controllers\Api\Admin\EdukasiController as AdminEdukasiController;
use App\Http\Controllers\Api\Admin\KategoriController;
use App\Http\Controllers\Api\Admin\KategoriEdukasiController;
use App\Http\Controllers\Api\Admin\PetugasController;
use App\Http\Controllers\Api\Admin\PuskesmasController;
use App\Http\Controllers\Api\Admin\UploadImageController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Dashboard\CekHbController;
use App\Http\Controllers\Api\Dashboard\JurnalMakanController;
use App\Http\Controllers\Api\Dashboard\KalkulatorController;
use App\Http\Controllers\Api\Dashboard\KonsumsiTtdController;
use App\Http\Controllers\Api\Dashboard\ReminderTtdController;
use App\Http\Controllers\Api\Edukasi\EdukasiController as IstriEdukasiController;
use App\Http\Controllers\Api\Petugas\AuthController as PetugasAuthController;
use App\Http\Controllers\Api\Petugas\DashboardController as PetugasDashboardController;
use App\Http\Controllers\Api\Profil\ProfilController;
use App\Http\Controllers\Api\Suami\Edukasi\EdukasiController as SuamiEdukasiController;
use App\Http\Controllers\Api\Suami\Profil\ProfilController as SuamiProfilController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\PetugasMiddleware;
use App\Http\Middleware\SuamiMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Istri Login
Route::post('/istri/login-token', [AuthController::class, 'istriLoginToken']);

// Suami Login
Route::post('/suami/login-token', [AuthController::class, 'suamiLogin']);

// Admin Register & Login
Route::post('/admin/register', [AdminAuthController::class, 'adminRegister']);
Route::post('/admin/login', [AdminAuthController::class, 'adminLogin']);

Route::post('/petugas/login', [PetugasAuthController::class, 'petugasLogin']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/istri/login', [AuthController::class, 'istriLogin']);
    Route::get('/istri/get-user', [AuthController::class, 'getUser']);

    // Profil Istri
    Route::post('/istri/profil/update-data-diri', [ProfilController::class, 'dataDiri']);
    Route::post('/istri/profil/update-data-kehamilan', [ProfilController::class, 'dataKehamilan']);
    Route::post('/istri/profil/update-data-suami', [ProfilController::class, 'dataSuami']);

    // Edukasi Istri
    Route::get('/istri/edukasi/get-edukasi', [IstriEdukasiController::class, 'getEdukasi']);
    Route::get('/istri/edukasi/show-edukasi/{id}', [IstriEdukasiController::class, 'showEdukasi']);

    // Kalkulator Anemia
    Route::post('/istri/dashboard/kalkulator-anemia', [KalkulatorController::class, 'kalkulatorAnemia']);

    // Konsumsi TTd
    Route::post('/istri/dashboard/konsumsi-ttd', [KonsumsiTtdController::class, 'konsumsiTablet']);
    Route::get('/istri/dashboard/get-konsumsi-ttd', [KonsumsiTtdController::class, 'getKonsumsiTabletUser']);

    // Reminder TTd
    Route::get('/istri/dashboard/get-user-reminder-ttd', [ReminderTtdController::class, 'getUserReminderTtd']);
    Route::post('/istri/dashboard/reminder-ttd', [ReminderTtdController::class, 'setReminderTtd']);

    // Jurnal Makan
    Route::get('/istri/dashboard/get-jurnal-makan', [JurnalMakanController::class, 'getJurnalMakan']);
    Route::get('/istri/dashboard/get-latest-jurnal-makan', [JurnalMakanController::class, 'getLatestJurnalMakan']);
    // Route::post('/istri/dashboard/jurnal-makan', [JurnalMakanController::class, 'insertJurnalMakan']);
    Route::post('/istri/dashboard/insert-sarapan', [JurnalMakanController::class, 'insertSarapan']);
    Route::post('/istri/dashboard/insert-makan-siang', [JurnalMakanController::class, 'insertMakanSiang']);
    Route::post('/istri/dashboard/insert-makan-malam', [JurnalMakanController::class, 'insertMakanMalam']);

    // Riwayat HB
    Route::get('/istri/dashboard/get-hb-terbaru', [CekHbController::class, 'getHbTerbaru']);
    Route::get('/istri/dashboard/get-count-cek-hb', [CekHbController::class, 'getCountCekHb']);
    Route::get('/istri/dashboard/get-user-hb', [CekHbController::class, 'getUserHb']);
    Route::post('/istri/dashboard/insert-riwayat-hb', [CekHbController::class, 'insertRiwayatHb']);

    /*==== Suami ==== */
    Route::middleware(SuamiMiddleware::class)->group(function () {
        Route::get('/suami/get-user', [AuthController::class, 'getUserSuami']);

        // Edukasi
        Route::get('/suami/edukasi/get-edukasi', [SuamiEdukasiController::class, 'getEdukasi']);
        Route::get('/suami/edukasi/show-edukasi/{id}', [SuamiEdukasiController::class, 'showEdukasi']);

        // Profil
        Route::post('/suami/profil/update-data-diri', [SuamiProfilController::class, 'updateDataDiri']);
        Route::post('/suami/profil/update-data-password', [SuamiProfilController::class, 'updatePassword']);
    });

    /*==== Admin ==== */
    Route::middleware([AdminMiddleware::class])->group(function () {
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
        Route::get('/admin/data-petugas-puskesmas/show/{id}', [PetugasController::class, 'showPetugasPuskesmas']);
        Route::post('/admin/data-petugas-puskesmas/update/{id}', [PetugasController::class, 'updatePetugasPuskesmas']);
        Route::post('/admin/data-petugas-puskesmas/delete/{id}', [PetugasController::class, 'deletePetugasPuskesmas']);

        // Admin Kategori Edukasi
        Route::get('/admin/data-kategori', [KategoriController::class, 'dataKategori']);
        Route::post('/admin/data-kategori/insert', [KategoriController::class, 'insertKategori']);
        Route::post('/admin/data-kategori/update/{id}', [KategoriController::class, 'updateKategori']);
        Route::post('/admin/data-kategori/delete/{id}', [KategoriController::class, 'deleteKategori']);
        Route::get('/admin/data-kategori-edukasi', [KategoriEdukasiController::class, 'dataKategoriEdukasi']);

        // Admin Data Edukasi
        Route::get('/admin/data-edukasi', [AdminEdukasiController::class, 'dataEdukasi']);
        Route::post('/admin/data-edukasi/insert', [AdminEdukasiController::class, 'insertEdukasi']);
        Route::get('/admin/data-edukasi/show/{id}', [AdminEdukasiController::class, 'showEdukasi']);
        Route::post('/admin/data-edukasi/update/{id}', [AdminEdukasiController::class, 'updateEdukasi']);
        Route::post('/admin/data-edukasi/delete/{id}', [AdminEdukasiController::class, 'deleteEdukasi']);

        // Upload Image to Cloudinary
        Route::post('/admin/upload-single-image', [UploadImageController::class, 'uploadSingleImage']);
    });

    Route::middleware(PetugasMiddleware::class)->group(function () {

        Route::get('/petugas/get-user', [PetugasAuthController::class, 'getUser']);

        Route::get('/petugas/dashboard', [PetugasDashboardController::class, 'petugasDashboard']);
    });
});
