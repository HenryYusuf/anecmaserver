<?php

use App\Http\Controllers\Api\Admin\AuthController as AdminAuthController;
use App\Http\Controllers\Api\Admin\DashboardController;
use App\Http\Controllers\Api\Admin\EdukasiController as AdminEdukasiController;
use App\Http\Controllers\Api\Admin\KategoriController;
use App\Http\Controllers\Api\Admin\KategoriEdukasiController;
use App\Http\Controllers\Api\Admin\PetugasController;
use App\Http\Controllers\Api\Admin\PuskesmasController;
use App\Http\Controllers\Api\Admin\RekapGiziController;
use App\Http\Controllers\Api\Admin\RekapHbController;
use App\Http\Controllers\Api\Admin\RekapKalkulatorAnemiaController;
use App\Http\Controllers\Api\Admin\RekapTtdController;
use App\Http\Controllers\Api\Admin\SettingController;
use App\Http\Controllers\Api\Admin\UploadImageController;
use App\Http\Controllers\Api\Admin\UserController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Dashboard\CekHbController;
use App\Http\Controllers\Api\Dashboard\JurnalMakanController;
use App\Http\Controllers\Api\Dashboard\KalkulatorController;
use App\Http\Controllers\Api\Dashboard\KonsumsiTtdController;
use App\Http\Controllers\Api\Dashboard\ReminderTtdController;
use App\Http\Controllers\Api\Edukasi\EdukasiController as IstriEdukasiController;
use App\Http\Controllers\Api\Petugas\AuthController as PetugasAuthController;
use App\Http\Controllers\Api\Petugas\DashboardController as PetugasDashboardController;
use App\Http\Controllers\Api\Petugas\RekapGiziController as PetugasRekapGiziController;
use App\Http\Controllers\Api\Petugas\RekapHbController as PetugasRekapHbController;
use App\Http\Controllers\Api\Petugas\RekapKalkulatorAnemiaController as PetugasRekapKalkulatorAnemiaController;
use App\Http\Controllers\Api\Petugas\RekapTtdController as PetugasRekapTtdController;
use App\Http\Controllers\Api\Petugas\UserController as PetugasUserController;
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
    Route::post('/istri/dashboard/turn-off-reminder-ttd', [ReminderTtdController::class, 'turnOffReminderTtd']);

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

        /* == Start Admin Data Rekap == */
        // Rekap TTD
        Route::get('/admin/data/rekap-ttd', [RekapTtdController::class, 'getRekapTtd']);
        // Rekap TTD > 90
        Route::get('/admin/data/rekap-ttd-90', [RekapTtdController::class, 'getRekapTtd90']);

        // Rekap Gizi
        Route::get('/admin/data/rekap-konsumsi-gizi', [RekapGiziController::class, 'getRekapGizi']);
        Route::get('/admin/data/detail-rekap-konsumsi-gizi/{id}', [RekapGiziController::class, 'getDetailRekapGizi']);

        // Rekap HB
        Route::get('/admin/data/rekap-hb', [RekapHbController::class, 'getRekapHb']);

        // Rekap Data Kalkulator Anemia
        Route::get('/admin/data/rekap-kalkulator-anemia', [RekapKalkulatorAnemiaController::class, 'getRekapKalkulatorAnemia']);
        /* == End Admin Data Rekap == */

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

        // Admin Data User
        Route::get('/admin/data-user', [UserController::class, 'getUser']);
        Route::post('/admin/data-user/delete/{id}', [UserController::class, 'deleteUser']);

        // Admin Update Profil
        Route::post('/admin/update-admin-profil/{id}', [SettingController::class, 'updateAdminProfil']);

        // Upload Image to Cloudinary
        Route::post('/admin/upload-single-image', [UploadImageController::class, 'uploadSingleImage']);

        // Export Excel
        Route::get('/admin/dashboard/export-data', [DashboardController::class, 'exportDataToExcel']);
        Route::get('/admin/rekap-ttd/export-data', [RekapTtdController::class, 'exportDataMonthToExcel']);
        Route::get('/admin/rekap-ttd-90/export-data', [RekapTtdController::class, 'exportData90ToExcel']);
        Route::get('/admin/rekap-hb/export-data', [RekapHbController::class, 'exportToExcel']);
        Route::get('/admin/rekap-gizi/export-data', [RekapGiziController::class, 'exportToExcel']);
        Route::get('/admin/rekap-kalkulator-anemia/export-data', [RekapKalkulatorAnemiaController::class, 'exportRekapKalkulatorAnemia']);
    });

    Route::middleware(PetugasMiddleware::class)->group(function () {

        Route::get('/petugas/get-user', [PetugasAuthController::class, 'getUser']);

        // Petugas Dashboard
        Route::get('/petugas/dashboard-card-hitung-data', [PetugasDashboardController::class, 'hitungData']);
        Route::get('/petugas/dashboard-data-terbaru', [PetugasDashboardController::class, 'dataTerbaru']);

        /* == Start Petugas Data Rekap == */
        // Rekap TTD
        Route::get('/petugas/data/rekap-ttd', [PetugasRekapTtdController::class, 'getRekapTtd']);
        // Rekap TTD > 90
        Route::get('/petugas/data/rekap-ttd-90', [PetugasRekapTtdController::class, 'getRekapTtd90']);

        // Rekap Gizi
        Route::get('/petugas/data/rekap-konsumsi-gizi', [PetugasRekapGiziController::class, 'getRekapGizi']);
        Route::get('/petugas/data/detail-rekap-konsumsi-gizi/{id}', [PetugasRekapGiziController::class, 'getDetailRekapGizi']);

        // Rekap HB
        Route::get('/petugas/data/rekap-hb', [PetugasRekapHbController::class, 'getRekapHb']);

        // Rekap Data Kalkulator Anemia
        Route::get('/petugas/data/rekap-kalkulator-anemia', [PetugasRekapKalkulatorAnemiaController::class, 'getRekapKalkulatorAnemia']);
        /* == End Petugas Data Rekap == */

        // Petugas Data User
        Route::get('/petugas/data-user', [PetugasUserController::class, 'getUser']);
        Route::post('/petugas/data-user/delete/{id}', [PetugasUserController::class, 'deleteUser']);

        // Export Excel
        Route::get('/petugas/dashboard/export-data', [PetugasDashboardController::class, 'exportDataToExcel']);
        Route::get('/petugas/rekap-ttd/export-data', [PetugasRekapTtdController::class, 'exportDataMonthToExcel']);
        Route::get('/petugas/rekap-ttd-90/export-data', [PetugasRekapTtdController::class, 'exportData90ToExcel']);
        Route::get('/petugas/rekap-hb/export-data', [PetugasRekapHbController::class, 'exportToExcel']);
        Route::get('/petugas/rekap-gizi/export-data', [PetugasRekapGiziController::class, 'exportToExcel']);
        Route::get('/petugas/rekap-kalkulator-anemia/export-data', [PetugasRekapKalkulatorAnemiaController::class, 'exportRekapKalkulatorAnemia']);
    });
});
