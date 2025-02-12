<?php

namespace App\Http\Controllers\Api\Admin;

use App\Exports\RekapGiziExport;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\JurnalMakan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class RekapGiziController extends BaseController
{
    public function getRekapGizi()
    {
        // $rekapGizi = User::with(['jurnal_makan_sorted'])->where('role', 'istri')->get();

        $rekapGizi = JurnalMakan::with('user')->get();

        return $this->sendResponse($rekapGizi, 'Rekap Konsumsi Gizi retrieved successfully.');
    }

    public function getDetailRekapGizi($id)
    {
        $rekapGizi = JurnalMakan::with('user')->find($id);

        return $this->sendResponse($rekapGizi, 'Detail Rekap Konsumsi Gizi retrieved successfully.');
    }

    public function exportToExcel()
    {
        $fileName = 'Rekap_Konsumsi_Gizi_' . date('Y-m-d_H-i-s') . '.xlsx';
        return Excel::download(new RekapGiziExport, $fileName);
    }
}
