<?php

namespace App\Http\Controllers\Api\Admin;

use App\Exports\RekapGiziExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class RekapGiziController extends Controller
{
    public function exportToExcel()
    {
        $fileName = 'Rekap_Konsumsi_Gizi_' . date('Y-m-d_H-i-s') . '.xlsx';
        return Excel::download(new RekapGiziExport, $fileName);
    }
}
