<?php

namespace App\Http\Controllers\Api\Admin;

use App\Exports\RekapHBExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class RekapHbController extends Controller
{
    public function exportToExcel()
    {
        $fileName = 'Rekap_HB_' . date('Y-m-d_H-i-s') . '.xlsx';
        return Excel::download(new RekapHBExport, $fileName);
    }
}
