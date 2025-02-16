<?php

namespace App\Http\Controllers\Api\Petugas;

use App\Exports\PetugasRekapGiziExport;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\JurnalMakan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class RekapGiziController extends BaseController
{
    public function getRekapGizi()
    {
        $user = Auth::user()->load('puskesmas');

        $alamat = $user->puskesmas->first()->alamat;

        // $rekapGizi = User::with(['jurnal_makan_sorted'])->where('role', 'istri')->get();

        $rekapGizi = JurnalMakan::with('user')
            ->whereHas('user', function ($query) use ($alamat) {
                $query->where('wilayah_binaan', $alamat);
            })->get();

        return $this->sendResponse($rekapGizi, 'Rekap Konsumsi Gizi retrieved successfully.');
    }

    public function getDetailRekapGizi($id)
    {
        $user = Auth::user()->load('puskesmas');

        $alamat = $user->puskesmas->first()->alamat;

        $rekapGizi = JurnalMakan::with('user')
            ->whereHas('user', function ($query) use ($alamat) {
                $query->where('wilayah_binaan', $alamat);
            })
            ->find($id);

        return $this->sendResponse($rekapGizi, 'Detail Rekap Konsumsi Gizi retrieved successfully.');
    }

    public function exportToExcel()
    {
        $fileName = 'Rekap_Konsumsi_Gizi_' . date('Y-m-d_H-i-s') . '.xlsx';
        return Excel::download(new PetugasRekapGiziExport, $fileName);
    }
}
