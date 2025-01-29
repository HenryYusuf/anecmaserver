<?php

namespace App\Exports;

use App\Models\User;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RekapHBExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $globalIndex = 0;

        return User::with(['cekHb'])
            ->where('role', 'istri')
            ->get()
            ->flatMap(function ($user) use (&$globalIndex) {
                if ($user->cekHb && $user->cekHb->isNotEmpty()) {
                    $riwayatHb = $user->cekHb->sortBy('tanggal')->values();

                    return $riwayatHb->map(function ($hb, $index) use ($user, &$globalIndex) {
                        $tanggal = Carbon::parse($hb->tanggal)->format('d/m/Y');
                        $globalIndex++;

                        return [
                            'no' => $globalIndex,
                            'name' => $user->name,
                            'urutan' => $index + 1,
                            'tanggal' => $tanggal,
                            'nilai_hb' => $hb->nilai_hb ?? '-',
                            'status_anemia' => $hb->hasil_pemeriksaan ?? '-',
                            'puskesmas' => $user->wilayah_binaan ?? '-',
                            'kelurahan' => $user->kelurahan ?? '-',
                        ];
                    });
                }

                return [];
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
            'Urutan Periksa',
            'Tanggal Input HB',
            'Hasil HB (g/dL)',
            'Status Anemia',
            'Puskesmas',
            'Kelurahan',
        ];
    }
}
