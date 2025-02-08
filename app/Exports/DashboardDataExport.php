<?php

namespace App\Exports;

use App\Models\User;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DashboardDataExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return User::with(['resikoAnemia', 'konsumsi_ttd', 'riwayat_hb'])
            ->where('role', 'istri')
            ->get()
            ->map(function ($user) {
                $tanggalLahir = $user->usia;
                $usia = $tanggalLahir ? Carbon::parse($tanggalLahir)->age : '-';

                $jumlahTtd = $user->konsumsi_ttd ? (string)$user->konsumsi_ttd->count() : '0';

                return [
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'usia' => $usia,
                    'resiko' => $user->resikoAnemia->first()->resiko ?? '-',
                    'ttd' => $jumlahTtd,
                    'nilai_hb' => $user->riwayat_hb->nilai_hb ?? '-',
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
            'NO',
            'Nama',
            'Usia',
            'Resiko Anemia',
            'Konsumsi TTD',
            'HB Terakhir',
        ];
    }
}
