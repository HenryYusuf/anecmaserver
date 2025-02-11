<?php

namespace App\Http\Controllers\Api\Admin;

use App\Exports\RekapTtd90Export;
use App\Exports\RekapTtdExport;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\KonsumsiTtd;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class RekapTtdController extends BaseController
{
    public function getRekapTtd()
    {
        // $rekapTTD = KonsumsiTtd::with('user.riwayat_hb')->paginate(5);
        $rekapTTD = KonsumsiTtd::whereIn('tanggal_waktu', function ($query) {
            $query->selectRaw('MAX(tanggal_waktu)')
                ->from('konsumsi_ttd')
                ->groupBy(DB::raw('YEAR(tanggal_waktu), MONTH(tanggal_waktu), user_id'));
        })->with('user.riwayat_hb')->get();

        return $this->sendResponse($rekapTTD, 'Rekap TTD retrieved successfully.');
    }

    public function exportDataMonthToExcel()
    {
        $fileName = 'Rekap_TTD_' . date('Y-m-d_H-i-s') . '.xlsx';
        return Excel::download(new RekapTtdExport, $fileName);
    }

    public function getRekapTtd90()
    {
        $rekapTTD = KonsumsiTtd::with('user.riwayat_hb')->get();

        // $filterTTD = $rekapTTD->groupBy('user_id')->filter(function ($item) {
        //     return $item->total_jumlah_ttd_dikonsumsi >= 90;
        // });

        $uniqueUsers = $rekapTTD->groupBy('user_id')->map(function ($items) {
            return $items->filter(function ($item) {
                return $item->total_jumlah_ttd_dikonsumsi >= 90;
            })->first();
        });

        return $this->sendResponse($uniqueUsers->filter()->values(), 'Rekap TTD retrieved successfully.');
    }

    public function exportData90ToExcel()
    {
        $fileName = 'Rekap_TTD > 90_' . date('Y-m-d_H-i-s') . '.xlsx';
        return Excel::download(new RekapTtd90Export, $fileName);
    }
}
