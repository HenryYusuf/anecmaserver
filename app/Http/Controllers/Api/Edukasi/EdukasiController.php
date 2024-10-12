<?php

namespace App\Http\Controllers\Api\Edukasi;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Edukasi;
use App\Models\ResikoAnemia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EdukasiController extends BaseController
{
    public function getEdukasi()
    {
        // Check User Login
        $user = Auth::user();

        // Check User Anemia by kalkulator/resiko anemia result
        $cekResiko = ResikoAnemia::where('user_id', $user->id)->first();

        // dd($cekResiko->resiko);

        if ($cekResiko->resiko == "rendah") {
            $results = Edukasi::orderByRaw("CASE WHEN kategori = 'pencegahan' THEN 0 ELSE 1 END") // Prioritaskan 'pencegahan'
                ->orderBy('created_at', 'desc')
                ->get();
        } else if ($cekResiko->resiko == "tinggi") {
            $results = Edukasi::orderByRaw("CASE WHEN kategori = 'edukasi' THEN 0 ELSE 1 END") // Prioritaskan 'edukasi'
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $results = Edukasi::orderBy('created_at', 'desc')->get();
        }

        return $this->sendResponse($results, 'Edukasi retrieved successfully.');
    }

    public function showEdukasi($id)
    {
        $edukasi = Edukasi::find($id);

        return $this->sendResponse($edukasi, 'Edukasi retrieved successfully.');
    }
}
