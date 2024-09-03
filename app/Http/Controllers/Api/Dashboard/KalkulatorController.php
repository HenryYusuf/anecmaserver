<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Api\BaseController;
use App\Models\ResikoAnemia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class KalkulatorController extends BaseController
{
    public function kalkulatorAnemia(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'usia_kehamilan' => 'required|numeric',
            'jumlah_anak' => 'required|numeric',
            'riwayat_anemia' => 'required',
            'konsumsi_ttd_7hari' => 'required',
            'hasil_hb' => 'required',
            'resiko' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $user = Auth::user();

        $resikoCreateOrUpdate = ResikoAnemia::updateOrCreate(
            ['user_id' => $user->id],
            [
                'usia_kehamilan' => $input['usia_kehamilan'],
                'jumlah_anak' => $input['jumlah_anak'],
                'riwayat_anemia' => $input['riwayat_anemia'],
                'konsumsi_ttd_7hari' => $input['konsumsi_ttd_7hari'],
                'hasil_hb' => $input['hasil_hb'],
                'resiko' => $input['resiko'],
            ]
        );

        return $this->sendResponse($resikoCreateOrUpdate, 'Resiko created or updated successfully.');
    }
}
