<?php

namespace App\Exports;

use App\Models\ResikoAnemia;
use Illuminate\Support\Facades\Date;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RekapKalkulatorAnemiaExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $globalIndex = 0;

        return ResikoAnemia::with('user')->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($item) use (&$globalIndex) {
                $globalIndex++;

                return [
                    'No' => $globalIndex,
                    'Nama Ibu Hamil' => $item->user->name,
                    'Usia Kehamilan' => $item->usia_kehamilan,
                    'Kelurahan' => $item->user->kelurahan,
                    'Tanggal Input' => Date::parse($item->created_at)->format('d/m/Y'),
                    'Jumlah Anak' => $item->jumlah_anak !== 0 ? $item->jumlah_anak : '0',
                    'Riwayat Anemia' => $item->riwayat_anemia == 1 ? 'Ya' : 'Tidak',
                    'Hasil Gizi' => $item->hasil_gizi,
                    'Konsumsi TTD 7 Hari' => $item->konsumsi_ttd_7hari,
                    'Lingkar Lengan Atas' => $item->lingkar_lengan_atas,
                    'Hasil HB' => $item->hasil_hb,
                    'Skor Resiko' => $item->skor_resiko,
                    'Resiko' => $item->resiko,
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
            'Usia Kehamilan',
            'Kelurahan',
            'Tanggal Input',
            'Jumlah Anak',
            'Riwayat Anemia',
            'Hasil Gizi',
            'Konsumsi TTD 7 Hari',
            'Lingkar Lengan Atas',
            'Hasil HB',
            'Skor Resiko',
            'Resiko',
        ];
    }
}
