<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\CekHb;
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

    public function insertRiwayatHb(Request $request)
    {
        $input = $request->all();

        // Validasi input
        $validator = Validator::make($input, [
            'nilai_hb' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $user = Auth::user();

        // Cek apakah user sudah mengisi pada hari ini
        $today = now()->startOfDay();
        $cekHbToday = CekHb::where('user_id', $user->id)
            ->whereDate('tanggal', $today)
            ->first();

        if ($cekHbToday) {
            // Jika sudah ada data, lakukan update
            $cekHbToday->update([
                'nilai_hb' => $input['nilai_hb'],
            ]);

            return $this->sendResponse($cekHbToday, 'Riwayat HB updated successfully.');
        } else {
            // Jika belum ada, lakukan insert
            $createCekHb = CekHb::create([
                'user_id' => $user->id,
                'tanggal' => now(),
                'nilai_hb' => $input['nilai_hb'],
            ]);

            return $this->sendResponse($createCekHb, 'Riwayat HB created successfully.');
        }
    }
}
