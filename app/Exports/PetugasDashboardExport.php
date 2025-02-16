<?php

namespace App\Exports;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PetugasDashboardExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $globalIndex = 0;

        $user = Auth::user()->load('puskesmas');

        $alamat = $user->puskesmas->first()->alamat;

        return User::with(['resikoAnemia', 'konsumsi_ttd', 'riwayat_hb'])
            ->where('role', 'istri')
            ->where('wilayah_binaan', $alamat)
            ->get()
            ->map(function ($user) use (&$globalIndex) {

                $globalIndex++;

                $tanggalLahir = $user->usia;
                $usia = $tanggalLahir ? Carbon::parse($tanggalLahir)->age : '-';

                $jumlahTtd = $user->konsumsi_ttd ? (string)$user->konsumsi_ttd->count() : '0';

                return [
                    'no' => $globalIndex,
                    'name' => $user->name,
                    'puskesmas' => $user->wilayah_binaan ?? '-',
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
            'Puskesmas',
            'Usia',
            'Resiko Anemia',
            'Konsumsi TTD',
            'HB Terakhir',
        ];
    }
}
