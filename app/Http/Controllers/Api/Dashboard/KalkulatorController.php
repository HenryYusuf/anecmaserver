<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KalkulatorController extends Controller
{
    public function kalkulatorAnemia(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'usia_kehamilan' => 'required|numeric',
            'jumlah_anak' => 'required|numeric',
            'riwayat_anemia' => 'required',
            'konsumsi_ttd_7hari' => 'required',
        ]);
    }
}
