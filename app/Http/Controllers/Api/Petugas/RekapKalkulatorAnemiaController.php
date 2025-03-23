<?php

namespace App\Http\Controllers\Api\Petugas;

use App\Exports\PetugasRekapKalkulatorAnemiaExport;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\ResikoAnemia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class RekapKalkulatorAnemiaController extends BaseController
{
    public function getRekapKalkulatorAnemia()
    {
        $user = Auth::user()->load('puskesmas');

        $alamat = $user->puskesmas->first()->alamat;

        $results = ResikoAnemia::with('user')->whereHas('user', function ($query) use ($alamat) {
            $query->where('wilayah_binaan', $alamat);
        })->get();

        return $this->sendResponse($results, 'Rekap Kalkulator Anemia retrieved successfully.');
    }

    public function exportRekapKalkulatorAnemia()
    {
        return Excel::download(new PetugasRekapKalkulatorAnemiaExport, 'rekap_kalkulator_anemia.xlsx');
    }
}
