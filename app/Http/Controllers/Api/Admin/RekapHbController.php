<?php

namespace App\Http\Controllers\Api\Admin;

use App\Exports\RekapHBExport;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\CekHb;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class RekapHbController extends BaseController
{
    public function getRekapHb()
    {
        $rekapHb = CekHb::with('user')->orderBy('tanggal', 'asc')->get();

        return $this->sendResponse($rekapHb, 'Rekap HB retrieved successfully.');
    }

    public function exportToExcel()
    {
        $fileName = 'Rekap_HB_' . date('Y-m-d_H-i-s') . '.xlsx';
        return Excel::download(new RekapHBExport, $fileName);
    }
}
