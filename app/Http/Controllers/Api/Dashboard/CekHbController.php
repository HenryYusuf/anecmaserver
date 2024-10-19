<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\CekHb;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CekHbController extends BaseController
{
    public function getHbTerbaru()
    {
        $user = Auth::user();

        $cekHb = CekHb::where('user_id', $user->id)->latest()->first();

        return $this->sendResponse($cekHb, 'Riwayat HB retrieved successfully.');
    }

    public function getCountCekHb()
    {
        $user = Auth::user();

        $cekHb = CekHb::where('user_id', $user->id)->count();

        $results = [
            'total_pemeriksaan' => $cekHb
        ];

        return $this->sendResponse($results, 'Count Cek HB retrieved successfully.');
    }

    public function getUserHb()
    {
        $user = Auth::user();

        $cekHb = CekHb::where('user_id', $user->id)->orderBy('tanggal', 'desc')->get();

        return $this->sendResponse($cekHb, 'Riwayat HB retrieved successfully.');
    }

    public function insertRiwayatHb(Request $request)
    {
        $input = $request->all();

        // Validasi input
        $validator = Validator::make($input, [
            'tanggal' => 'required',
            'nilai_hb' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $user = Auth::user();

        $hariPertamaHaid = $user->hari_pertama_haid;
        $startDate = Carbon::create($hariPertamaHaid);
        // $startDate = Carbon::create(2023, 9, 1);
        $currentDate = Carbon::now();

        $weekPassed = floor($startDate->diffInWeeks($currentDate));

        // Cek apakah ada riwayat pemeriksaan sebelumnya
        $previousHb = CekHb::where('user_id', $user->id)->latest('created_at')->first();

        // dd($weekPassed);
        $hasilPemeriksaan = "";
        if (($weekPassed >= 0 && $weekPassed <= 12) || $weekPassed >= 25) {
            // Trisemester 1 atau 3
            $hasilPemeriksaan = ($input['nilai_hb'] >= 11) ? "normal" : "anemia";
        } elseif ($weekPassed >= 13 && $weekPassed <= 24) {
            // Trisemester 2
            $hasilPemeriksaan = ($input['nilai_hb'] >= 10.5) ? "normal" : "anemia";
        }

        // Tentukan pesan berdasarkan hasil pemeriksaan saat ini dan sebelumnya
        $pesan = "";
        if ($hasilPemeriksaan == "anemia") {
            if (is_null($previousHb)) {
                // Pemeriksaan pertama dan hasil anemia
                $pesan = "Bunda mengalami anemia, ayo tingkatkan konsumsi makanan pencegah anemia dan rutin mengonsumsi tablet tambah darah";
            } elseif ($previousHb->hasil_pemeriksaan == "normal") {
                // Sebelumnya normal, sekarang anemia
                $pesan = "Bunda saat ini mengalami anemia, ayo tingkatkan konsumsi makanan pencegah anemia dan rutin mengonsumsi tablet tambah darah";
            } elseif ($previousHb->hasil_pemeriksaan == "anemia") {
                // Sebelumnya anemia, sekarang masih anemia
                $pesan = "Hasil pemeriksaan Hb Bunda masih sama, Bunda mengalami anemia, ayo tingkatkan konsumsi makanan pencegah anemia dan rutin mengonsumsi tablet tambah darah";
            }
        } elseif ($hasilPemeriksaan == "normal") {
            if (is_null($previousHb)) {
                // Pemeriksaan pertama dan hasil tidak anemia
                $pesan = "Selamat, Bunda tidak mengalami anemia, ayo pertahankan konsumsi makanan pencegah anemia dan rutin mengonsumsi tablet tambah darah";
            } elseif ($previousHb->hasil_pemeriksaan == "anemia") {
                // Sebelumnya anemia, sekarang normal
                $pesan = "Selamat! Hasil pemeriksaan Hb menunjukkan Bunda sudah tidak mengalami anemia, ayo pertahankan konsumsi makanan pencegah anemia dan rutin mengonsumsi tablet tambah darah";
            } elseif ($previousHb->hasil_pemeriksaan == "normal") {
                // Sebelumnya normal, sekarang normal
                $pesan = "Selamat, Bunda tidak mengalami anemia, ayo pertahankan konsumsi makanan pencegah anemia dan rutin mengonsumsi tablet tambah darah";
            }
        }

        $createCekHb = CekHb::create([
            'user_id' => $user->id,
            'tanggal' => $input['tanggal'],
            'nilai_hb' => $input['nilai_hb'],
            'usia_kehamilan' => $weekPassed,
            'hasil_pemeriksaan' => $hasilPemeriksaan
        ]);

        // Return response beserta pesan
        return $this->sendResponse([
            'data' => $createCekHb,
            'pesan' => $pesan
        ], 'Riwayat HB created successfully.');
    }

    // public function insertRiwayatHb(Request $request)
    // {
    //     $input = $request->all();

    //     // Validasi input
    //     $validator = Validator::make($input, [
    //         'nilai_hb' => 'required|numeric',
    //     ]);

    //     if ($validator->fails()) {
    //         return $this->sendError('Validation Error.', $validator->errors());
    //     }

    //     $user = Auth::user();

    //     // Cek apakah user sudah mengisi pada hari ini
    //     $today = now()->startOfDay();
    //     $cekHbToday = CekHb::where('user_id', $user->id)
    //         ->whereDate('tanggal', $today)
    //         ->first();

    //     if ($cekHbToday) {
    //         // Jika sudah ada data, lakukan update
    //         $cekHbToday->update([
    //             'nilai_hb' => $input['nilai_hb'],
    //         ]);

    //         return $this->sendResponse($cekHbToday, 'Riwayat HB updated successfully.');
    //     } else {
    //         // Jika belum ada, lakukan insert
    //         $createCekHb = CekHb::create([
    //             'user_id' => $user->id,
    //             'tanggal' => now(),
    //             'nilai_hb' => $input['nilai_hb'],
    //         ]);

    //         return $this->sendResponse($createCekHb, 'Riwayat HB created successfully.');
    //     }
    // }
}
