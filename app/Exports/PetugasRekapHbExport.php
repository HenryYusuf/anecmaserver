<?php

namespace App\Exports;

use App\Models\CekHb;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PetugasRekapHbExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $globalIndex = 0;

        $user = Auth::user()->load('puskesmas');

        $alamat = $user->puskesmas->first()->alamat;

        return CekHb::with('user')
            ->whereHas('user', function ($query) use ($alamat) {
                $query->where('wilayah_binaan', $alamat);
            })
            ->orderBy('tanggal', 'asc')
            ->get()
            ->map(function ($item) use (&$globalIndex) {
                $globalIndex++;

                return [
                    'No' => $globalIndex,
                    'Nama Ibu Hamil' => $item->user->name,
                    'Urutan Periksa' => $item->urutan_periksa,
                    'Tanggal Input HB' => Carbon::parse($item->tanggal)->format('d/m/Y'),
                    'Hasil HB (g/dL)' => $item->nilai_hb ?? '-',
                    'Status Anemia' => $item->hasil_pemeriksaan ?? '-',
                    'Puskesmas' => $item->user->wilayah_binaan ?? '-',
                    'Kelurahan' => $item->user->kelurahan ?? '-',
                ];
            });
    }

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
