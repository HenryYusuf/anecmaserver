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
        // $rekapTTD = KonsumsiTtd::whereIn('tanggal_waktu', function ($query) {
        //     $query->selectRaw('MAX(tanggal_waktu)')
        //         ->from('konsumsi_ttd')
        //         ->groupBy(DB::raw('YEAR(tanggal_waktu), MONTH(tanggal_waktu), user_id'));
        // })->with('user.riwayat_hb')->get();

        // $rekapKonsumsiTtd = DB::table('konsumsi_ttd')
        //     ->select([
        //         'user_id',
        //         DB::raw('YEAR(tanggal_waktu) as tahun'),
        //         DB::raw('MONTH(tanggal_waktu) as bulan'),
        //         DB::raw('SUM(COALESCE(total_tablet_diminum, 0)) as total_tablet_diminum'),
        //         DB::raw('SUM(COALESCE(total_tablet_diminum, 0)) / COUNT(DISTINCT DATE(tanggal_waktu)) as rata_rata_perhari'),
        //         DB::raw('SUM(CASE WHEN minum_vit_c = true THEN 1 ELSE 0 END) > SUM(CASE WHEN minum_vit_c = false THEN 1 ELSE 0 END) as lebih_banyak_vit_c')
        //     ])
        //     ->whereNotNull('tanggal_waktu')
        //     ->groupBy('user_id')
        //     ->groupBy(DB::raw('YEAR(tanggal_waktu)'))
        //     ->groupBy(DB::raw('MONTH(tanggal_waktu)'))
        //     ->get();

        // $rekapCekHb = DB::table('cek_hb')
        //     ->whereNotNull('tanggal') // Pastikan tanggal tidak null
        //     ->select([
        //         'user_id',
        //         DB::raw('YEAR(tanggal) as tahun'), // Ambil tahun dari tanggal
        //         DB::raw('MONTH(tanggal) as bulan'), // Ambil bulan dari tanggal
        //         DB::raw('SUM(nilai_hb) as total_nilai_hb'),
        //         DB::raw('AVG(nilai_hb) as rata_rata_perhari')
        //     ])
        //     ->groupBy('user_id', DB::raw('YEAR(tanggal)'), DB::raw('MONTH(tanggal)')) // Group by user, tahun, bulan
        //     ->orderBy('user_id')
        //     ->orderBy('tahun')
        //     ->orderBy('bulan')
        //     ->get()
        //     ->toArray();

        // $rekapTtd = DB::table('konsumsi_ttd')
        //     ->join('cek_hb', function ($join) {
        //         $join->on('konsumsi_ttd.user_id', '=', 'cek_hb.user_id')
        //             ->on(DB::raw('YEAR(konsumsi_ttd.tanggal_waktu)'), '=', DB::raw('YEAR(cek_hb.tanggal)'))
        //             ->on(DB::raw('MONTH(konsumsi_ttd.tanggal_waktu)'), '=', DB::raw('MONTH(cek_hb.tanggal)'));
        //     })
        //     ->select([
        //         'konsumsi_ttd.user_id',
        //         DB::raw('YEAR(konsumsi_ttd.tanggal_waktu) as tahun'),
        //         DB::raw('MONTH(konsumsi_ttd.tanggal_waktu) as bulan'),
        //         DB::raw('SUM(COALESCE(konsumsi_ttd.total_tablet_diminum, 0)) as total_tablet_diminum'),
        //         DB::raw('SUM(COALESCE(konsumsi_ttd.total_tablet_diminum, 0)) / COUNT(DISTINCT DATE(konsumsi_ttd.tanggal_waktu)) as rata_rata_perhari'),
        //         DB::raw('SUM(CASE WHEN konsumsi_ttd.minum_vit_c = true THEN 1 ELSE 0 END) > SUM(CASE WHEN konsumsi_ttd.minum_vit_c = false THEN 1 ELSE 0 END) as lebih_banyak_vit_c'),
        //         DB::raw('SUM(cek_hb.nilai_hb) as total_nilai_hb'),
        //         DB::raw('AVG(cek_hb.nilai_hb) as rata_rata_hb_perhari')
        //     ])
        //     ->whereNotNull('konsumsi_ttd.tanggal_waktu')
        //     ->whereNotNull('cek_hb.tanggal')
        //     ->groupBy('konsumsi_ttd.user_id', DB::raw('YEAR(konsumsi_ttd.tanggal_waktu)'), DB::raw('MONTH(konsumsi_ttd.tanggal_waktu)'))
        //     ->orderBy('konsumsi_ttd.user_id')
        //     ->orderBy('tahun')
        //     ->orderBy('bulan')
        //     ->get();

        // Rata rata perhari berdasarkan data yang ada di bulan tertentu
        // $rekapKonsumsiTtd = KonsumsiTtd::with('user.riwayat_hb')
        //     ->select([
        //         'user_id',
        //         DB::raw('YEAR(tanggal_waktu) as tahun'),
        //         DB::raw('MONTH(tanggal_waktu) as bulan'),
        //         DB::raw('SUM(COALESCE(total_tablet_diminum, 0)) as total_tablet_diminum'),
        //         DB::raw('SUM(COALESCE(total_tablet_diminum, 0)) / COUNT(DISTINCT DATE(tanggal_waktu)) as rata_rata_perhari'),
        //         DB::raw('SUM(CASE WHEN minum_vit_c = true THEN 1 ELSE 0 END) > SUM(CASE WHEN minum_vit_c = false THEN 1 ELSE 0 END) as lebih_banyak_vit_c')
        //     ])
        //     ->whereNotNull('tanggal_waktu')
        //     ->groupBy('user_id', DB::raw('YEAR(tanggal_waktu)'), DB::raw('MONTH(tanggal_waktu)'))
        //     ->get();

        // Rata rata perhari berdasarkan hari yang ada di bulan dikurangi dengan jumlah hari terakhir di bulan tersebut
        // // Untuk total tablet diminum
        // $rekapKonsumsiTtd = KonsumsiTtd::with('user.riwayat_hb')
        //     ->select([
        //         'user_id',
        //         DB::raw('YEAR(tanggal_waktu) as tahun'),
        //         DB::raw('MONTH(tanggal_waktu) as bulan'),
        //         DB::raw('SUM(COALESCE(total_tablet_diminum, 0)) as total_tablet_diminum'), 
        //         DB::raw('SUM(COALESCE(total_tablet_diminum, 0)) / DAY(LAST_DAY(MAX(tanggal_waktu))) as rata_rata_perhari'),
        //         DB::raw('MAX(COALESCE(total_tablet_diminum, 0)) as max_tablet_per_hari'),
        //         DB::raw('SUM(CASE WHEN minum_vit_c = true THEN 1 ELSE 0 END) > SUM(CASE WHEN minum_vit_c = false THEN 1 ELSE 0 END) as lebih_banyak_vit_c')
        //     ])
        //     ->whereNotNull('tanggal_waktu')
        //     ->groupBy('user_id', DB::raw('YEAR(tanggal_waktu)'), DB::raw('MONTH(tanggal_waktu)'))
        //     ->get();


        // revisi
        $rekapKonsumsiTtd = KonsumsiTtd::with('user.riwayat_hb')
            ->select([
                'user_id',
                DB::raw('YEAR(tanggal_waktu) as tahun'),
                DB::raw('MONTH(tanggal_waktu) as bulan'),
                DB::raw('MAX(CASE WHEN total_tablet_diminum BETWEEN 1 AND 2 THEN total_tablet_diminum END) as max_tablet'),
                DB::raw('SUM(total_tablet_diminum) as sum_tablet'),
                DB::raw('SUM(minum_vit_c = 1) as count_vit_c_1'),
                DB::raw('SUM(minum_vit_c = 0) as count_vit_c_0')
            ])
            ->whereNotNull('tanggal_waktu')
            ->groupBy('user_id', DB::raw('YEAR(tanggal_waktu)'), DB::raw('MONTH(tanggal_waktu)'))
            ->get();



        return $this->sendResponse($rekapKonsumsiTtd, 'Rekap TTD retrieved successfully.');
    }

    public function exportDataMonthToExcel()
    {
        $fileName = 'Rekap_TTD_' . date('Y-m-d_H-i-s') . '.xlsx';
        return Excel::download(new RekapTtdExport, $fileName);
    }

    public function getRekapTtd90()
    {
        // $rekapTTD = KonsumsiTtd::with('user.riwayat_hb')->get();

        // $filterTTD = $rekapTTD->groupBy('user_id')->filter(function ($item) {
        //     return $item->total_jumlah_ttd_dikonsumsi >= 90;
        // });

        // $uniqueUsers = $rekapTTD->groupBy('user_id')->map(function ($items) {
        //     return $items->filter(function ($item) {
        //         return $item->total_jumlah_ttd_dikonsumsi >= 90;
        //     })->first();
        // });

        $rekapTTD = KonsumsiTtd::with('user.riwayat_hb')
            ->join(
                DB::raw('(SELECT user_id, SUM(total_tablet_diminum) as total_jumlah
                     FROM konsumsi_ttd
                     GROUP BY user_id
                     HAVING total_jumlah >= 90) as ttd_summary'),
                'konsumsi_ttd.user_id',
                '=',
                'ttd_summary.user_id'
            )
            ->whereRaw('konsumsi_ttd.id = (SELECT id FROM konsumsi_ttd WHERE konsumsi_ttd.user_id = ttd_summary.user_id ORDER BY created_at DESC LIMIT 1)')
            ->select('konsumsi_ttd.*', 'ttd_summary.total_jumlah')
            ->get();


        return $this->sendResponse($rekapTTD, 'Rekap TTD retrieved successfully.');
    }

    public function exportData90ToExcel()
    {
        $fileName = 'Rekap_TTD > 90_' . date('Y-m-d_H-i-s') . '.xlsx';
        return Excel::download(new RekapTtd90Export, $fileName);
    }
}
