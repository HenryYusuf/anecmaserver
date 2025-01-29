<?php

namespace App\Exports;

use App\Models\User;
use Carbon\Carbon;
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

        return User::with(['cekHb', 'konsumsi_ttd'])
            ->where('role', 'istri')
            ->get()
            ->map(function ($user) use (&$globalIndex) {
                $globalIndex++;

                $hbTerakhir = $user->cekHb && $user->cekHb->isNotEmpty()
                    ? $user->cekHb->sortByDesc('tanggal')->first()->nilai_hb
                    : '-';

                $totalTtd = $user->konsumsi_ttd ? (string)$user->konsumsi_ttd->count() : '0';

                return [
                    'no' => $globalIndex,
                    'name' => $user->name,
                    'jumlah_total_TTD' => $totalTtd,
                    'hb_terakhir' => $hbTerakhir,
                    'puskesmas' => $user->wilayah_binaan ?? '-',
                    'kelurahan' => $user->kelurahan ?? '-',
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
