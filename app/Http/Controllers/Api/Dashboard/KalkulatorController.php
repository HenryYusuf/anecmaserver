<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Api\BaseController;
use App\Models\CekHb;
use App\Models\JurnalMakan;
use App\Models\ResikoAnemia;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class KalkulatorController extends BaseController
{
    public function kalkulatorAnemia(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            // 'usia_kehamilan' => 'required',
            'jumlah_anak' => 'required',
            'riwayat_anemia' => 'required',
            // 'hasil_gizi' => 'required',
            'konsumsi_ttd_7hari' => 'required',
            'lingkar_lengan_atas' => 'required',
            // 'hasil_hb' => 'required',
            // 'resiko' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $user = Auth::user();


        // Cek usia kehamilan berdasar trisemester
        $hariPertamaHaid = $user->hari_pertama_haid;
        // $startDate = Carbon::create($hariPertamaHaid);
        $startDate = Carbon::create(2023, 9, 1);
        $currentDate = Carbon::now();
        $weekPassed = floor($startDate->diffInWeeks($currentDate));

        // Hasil Gizi dari Jurnal Makan Terbaru
        $checkJurnalMakanUser = JurnalMakan::where('user_id', $user->id)->latest()->first();

        // Hasil Cek HB Terbaru
        $cekHb = CekHb::where('user_id', $user->id)->latest()->first();

        $total_score = 0;
        // Skor untuk usia kehamilan
        if ($weekPassed <= 12) {
            $total_score += 0;
            // dd($total_score);
        } else if ($weekPassed > 12) {
            $total_score += 1;
            // dd($total_score);
        }

        // Skor untuk jumlah anak yang pernah dilahirkan
        if ($input['jumlah_anak'] <= 1) {
            $total_score += 0;
            // dd($total_score);
        } else if ($input['jumlah_anak'] > 1) {
            $total_score += 1;
            // dd($total_score);
        }

        // Skor untuk riwayat anemia (1 = pernah, 0 = tidak pernah)
        if ($input['riwayat_anemia'] == 1) {
            $total_score += 1;
            // dd($total_score);
        } else if ($input['riwayat_anemia'] == 0) {
            $total_score += 0;
            // dd($total_score);
        }

        // Skor untuk hasil gizi
        if (strtolower($checkJurnalMakanUser->hasil_gizi) == "gizi seimbang") {
            $total_score += 0;
            // dd($total_score);
        } else if (strtolower($checkJurnalMakanUser->hasil_gizi) == "gizi tidak seimbang") {
            $total_score += 1;
            // dd($total_score);
        }

        // Skor untuk konsumsi ttd 7 hari
        if ($input['konsumsi_ttd_7hari'] <= 2) {
            $total_score += 3;
            // dd($total_score);
        } else if ($input['konsumsi_ttd_7hari'] >= 3 && $input['konsumsi_ttd_7hari'] <= 4) {
            $total_score += 2;
            // dd($total_score);
        } else if ($input['konsumsi_ttd_7hari'] >= 5 && $input['konsumsi_ttd_7hari'] <= 6) {
            $total_score += 1;
            // dd($total_score);
        } else if ($input['konsumsi_ttd_7hari'] >= 7) {
            $total_score += 0;
            // dd($total_score);
        }

        // Skor untuk lingkar lengan atas
        if ($input['lingkar_lengan_atas'] < 23.5) {
            $total_score += 1;
            // dd($total_score);
        } else if ($input['lingkar_lengan_atas'] >= 23.5) {
            $total_score += 0;
            // dd($total_score);
        }

        // Skor untuk riwayat HB
        if ($cekHb->hasil_pemeriksaan == 'anemia') {
            $total_score += 4;
            // dd($total_score);
        } else if ($cekHb->hasil_pemeriksaan == 'normal') {
            $total_score += 0;
            // dd($total_score);
        }

        // Hasil Keputusan
        if ($total_score <= 6) {
            $resiko_anemia = "rendah";
        } else if ($total_score >= 7) {
            $resiko_anemia = "tinggi";
        }

        $resikoCreateOrUpdate = ResikoAnemia::updateOrCreate(
            ['user_id' => $user->id],
            [
                'usia_kehamilan' => $weekPassed,
                'jumlah_anak' => $input['jumlah_anak'],
                'riwayat_anemia' => $input['riwayat_anemia'],
                'hasil_gizi' => $checkJurnalMakanUser->hasil_gizi,
                'konsumsi_ttd_7hari' => $input['konsumsi_ttd_7hari'],
                'lingkar_lengan_atas' => $input['lingkar_lengan_atas'],
                'hasil_hb' => $cekHb->nilai_hb,
                'skor_resiko' => $total_score,
                'resiko' => $resiko_anemia,
            ]
        );

        return $this->sendResponse($resikoCreateOrUpdate, 'Resiko created or updated successfully.');
    }
}
