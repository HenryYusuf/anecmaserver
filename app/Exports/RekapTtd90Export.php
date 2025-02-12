<?php

namespace App\Exports;

use App\Models\KonsumsiTtd;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RekapTtd90Export implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $globalIndex = 0;

        // return User::with(['cekHb', 'konsumsi_ttd'])
        //     ->where('role', 'istri')
        //     ->get()
        //     ->map(function ($user) use (&$globalIndex) {
        //         $globalIndex++;

        //         $hbTerakhir = $user->cekHb && $user->cekHb->isNotEmpty()
        //             ? $user->cekHb->sortByDesc('tanggal')->first()->nilai_hb
        //             : '-';

        //         $totalTtd = $user->konsumsi_ttd ? (string)$user->konsumsi_ttd->count() : '0';

        //         return [
        //             'no' => $globalIndex,
        //             'name' => $user->name,
        //             'jumlah_total_TTD' => $totalTtd,
        //             'hb_terakhir' => $hbTerakhir,
        //             'puskesmas' => $user->wilayah_binaan ?? '-',
        //             'kelurahan' => $user->kelurahan ?? '-',
        //         ];
        //     });

        return KonsumsiTtd::with('user.riwayat_hb')
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
            ->get()
            ->map(function ($item) use (&$globalIndex) {
                $globalIndex++;

                return [
                    'No' => $globalIndex,
                    'Nama Ibu Hamil' => $item->user->name ?? '-',
                    'Jumlah Total TTD' => $item->total_jumlah,
                    'HB Terakhir (g/dL)' => $item->user->riwayat_hb->nilai_hb ?? '-',
                    'Puskesmas' => $item->user->wilayah_binaan ?? '-',
                    'Kelurahan' => $item->user->kelurahan ?? '-',
                ];
            });
    }

    /**
     * Define the headings for the Excel file.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'No',
            'Nama Ibu Hamil',
            'Jumlah Total TTD',
            'HB Terakhir (g/dL)',
            'Puskesmas',
            'Kelurahan',
        ];
    }
}
