<?php

namespace App\Http\Controllers\Api\Petugas;

use App\Exports\PetugasRekapHbExport;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\CekHb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class RekapHbController extends BaseController
{
    public function getRekapHb()
    {
        $user = Auth::user()->load('puskesmas');

        $alamat = $user->puskesmas->first()->alamat;

        $rekapHb = CekHb::with('user')
            ->whereHas('user', function ($query) use ($alamat) {
                $query->where('wilayah_binaan', $alamat);
            })
            ->orderBy('tanggal', 'asc')
            ->get();

        return $this->sendResponse($rekapHb, 'Rekap HB retrieved successfully.');
    }

    public function exportToExcel()
    {
        $fileName = 'Rekap_HB_' . date('Y-m-d_H-i-s') . '.xlsx';
        return Excel::download(new PetugasRekapHbExport, $fileName);
    }
}
