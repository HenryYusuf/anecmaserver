<?php

namespace App\Http\Controllers\Api\Edukasi;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Edukasi;
use App\Models\Kategori;
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
        if (!$cekResiko) {
            $results = Kategori::with('edukasi')->where('gender', 'istri')->inRandomOrder()->get()->flatMap(function ($kategori) {
                return $kategori->edukasi;
            });
            return $this->sendResponse($results, 'Edukasi retrieved successfully.');
        }

        if ($cekResiko->resiko == "rendah") {
            // $results = Edukasi::orderByRaw("CASE WHEN kategori = 'pencegahan' THEN 0 ELSE 1 END") // Prioritaskan 'pencegahan'
            //     ->inRandomOrder()
            //     ->get();
            $results = Kategori::with('edukasi')->has('edukasi')->whereNull('parent_id')->where('gender', 'istri')->get();
        } else if ($cekResiko->resiko == "tinggi") {
            // $results = Edukasi::orderByRaw("CASE WHEN kategori = 'edukasi' THEN 0 ELSE 1 END") // Prioritaskan 'edukasi'
            //     ->inRandomOrder()
            //     ->get();
            $results = Kategori::with(['kategori_child.edukasi'])->whereNull('parent_id')->where('gender', 'istri')->limit(2)->get();
        } else {
            // $results = [
            //     'data' => 'Silahkan cek resiko anemia di kalkulator anemia terlebih dahulu!'
            // ];
            $results = Kategori::with('edukasi')->where('gender', 'istri')->inRandomOrder()->get()->flatMap(function ($kategori) {
                return $kategori->edukasi;
            });
        }

        return $this->sendResponse($results, 'Edukasi retrieved successfully.');
    }

    public function showEdukasi($id)
    {
        $edukasi = Edukasi::find($id);

        return $this->sendResponse($edukasi, 'Edukasi retrieved successfully.');
    }
}
