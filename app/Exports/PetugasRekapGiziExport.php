<?php

namespace App\Exports;

use App\Models\JurnalMakan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PetugasRekapGiziExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $user = Auth::user()->load('puskesmas');

        $alamat = $user->puskesmas->first()->alamat;

        return JurnalMakan::with('user')
            ->whereHas('user', function ($query) use ($alamat) {
                $query->where('wilayah_binaan', $alamat);
            })
            ->get()
            ->map(function ($item) use (&$globalIndex) {
                $globalIndex++;

                return [
                    'No' => $globalIndex,
                    'Nama Ibu Hamil' => $item->user->name,
                    'Puskesmas' => $item->user->wilayah_binaan,
                    'Kelurahan' => $item->user->kelurahan,
                    'Usia Kehamilan' => $item->usia_kehamilan,
                    'Tanggal Input' => $item->tanggal ? Carbon::parse($item->tanggal)->format('d/m/Y') : '-',
                    'Sarapan Karbohidrat (Porsi)' => (string) ($item->sarapan_karbohidrat ?? '0'),
                    'Sarapan Lauk Hewani (Porsi)' => (string) ($item->sarapan_lauk_hewani ?? '0'),
                    'Sarapan Lauk Nabati (Porsi)' => (string) ($item->sarapan_lauk_nabati ?? '0'),
                    'Sarapan Sayur (Porsi)' => (string) ($item->sarapan_sayur ?? '0'),
                    'Sarapan Buah (Porsi)' => (string) ($item->sarapan_buah ?? '0'),
                    'Makan Siang Karbohidrat (Porsi)' => (string) ($item->makan_siang_karbohidrat ?? '0'),
                    'Makan Siang Lauk Hewani (Porsi)' => (string) ($item->makan_siang_lauk_hewani ?? '0'),
                    'Makan Siang Lauk Nabati (Porsi)' => (string) ($item->makan_siang_lauk_nabati ?? '0'),
                    'Makan Siang Sayur (Porsi)' => (string) ($item->makan_siang_sayur ?? '0'),
                    'Makan Siang Buah (Porsi)' => (string) ($item->makan_siang_buah ?? '0'),
                    'Makan Malam Karbohidrat (Porsi)' => (string) ($item->makan_malam_karbohidrat ?? '0'),
                    'Makan Malam Lauk Hewani (Porsi)' => (string) ($item->makan_malam_lauk_hewani ?? '0'),
                    'Makan Malam Lauk Nabati (Porsi)' => (string) ($item->makan_malam_lauk_nabati ?? '0'),
                    'Makan Malam Sayur (Porsi)' => (string) ($item->makan_malam_sayur ?? '0'),
                    'Makan Malam Buah (Porsi)' => (string) ($item->makan_malam_buah ?? '0'),
                    'Total Kalori Karbohidrat' => (string) ($item->total_kalori_karbohidrat ?? '0'),
                    'Total Kalori Lauk Hewani' => (string) ($item->total_kalori_lauk_hewani ?? '0'),
                    'Total Kalori Lauk Nabati' => (string) ($item->total_kalori_lauk_nabati ?? '0'),
                    'Total Kalori Sayur' => (string) ($item->total_kalori_sayur),
                    'Total Kalori Buah' => (string) ($item->total_kalori_buah ?? '0'),
                    'Total Kalori' => (string) ($item->total_kalori ?? '0'),
                    'Konsumsi Gizi' => (string) ($item->hasil_gizi ? $item->hasil_gizi : '-'),
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
            'Puskesmas',
            'Kelurahan',
            'Usia Kehamilan',
            'Tanggal Input',
            'Sarapan Karbohidrat (Porsi)',
            'Sarapan Lauk Hewani (Porsi)',
            'Sarapan Lauk Nabati (Porsi)',
            'Sarapan Sayur (Porsi)',
            'Sarapan Buah (Porsi)',
            'Makan Siang Karbohidrat (Porsi)',
            'Makan Siang Lauk Hewani (Porsi)',
            'Makan Siang Lauk Nabati (Porsi)',
            'Makan Siang Sayur (Porsi)',
            'Makan Siang Buah (Porsi)',
            'Makan Malam Karbohidrat (Porsi)',
            'Makan Malam Lauk Hewani (Porsi)',
            'Makan Malam Lauk Nabati (Porsi)',
            'Makan Malam Sayur (Porsi)',
            'Makan Malam Buah (Porsi)',
            'Total Porsi Karbohidrat',
            'Total Porsi Lauk Hewani',
            'Total Porsi Lauk Nabati',
            'Total Porsi Sayur',
            'Total Porsi Buah',
            'Total Porsi',
            'Konsumsi Gizi'
        ];
    }
}
