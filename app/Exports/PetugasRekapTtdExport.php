<?php

namespace App\Exports;

use App\Models\KonsumsiTtd;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PetugasRekapTtdExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $globalIndex = 0;

        $user = Auth::user()->load('puskesmas');

        $alamat = $user->puskesmas->first()->alamat;

        // return User::with('konsumsi_ttd', 'cekHb')
        //     ->where('role', 'istri')
        //     ->get()
        //     ->flatMap(function ($user) {
        //         // Ambil konsumsi TTD berdasarkan bulan dan kategori
        //         return $this->getKonsumsiTtdData($user);
        //     })
        //     ->map(function ($item, $index) {
        //         // Menambahkan kolom No di awal array (untuk urutan)
        //         $item = collect($item)->toArray(); // Pastikan item adalah array
        //         array_unshift($item, $index + 1); // Menambahkan No di depan array
        //         return $item;
        //     });

        // Rata rata perhari berdasarkan data yang ada di bulan tertentu
        // return KonsumsiTtd::with('user.riwayat_hb')
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
        //     ->get()
        //     ->map(function ($item) use (&$globalIndex) {
        //         $globalIndex++;

        //         return [
        //             'No' => $globalIndex,
        //             'Nama Ibu Hamil' => $item->user->name ?? '-',
        //             'Puskesmas' => $item->user->wilayah_binaan ?? '-',
        //             'Kadar HB (g/dL) Terakhir' => $item->user->riwayat_hb->nilai_hb ?? '-',
        //             'Jumlah Tablet TTD Per Hari' => number_format($item->rata_rata_perhari, 2),
        //             'Total Jumlah TTD yang Dikonsumsi' => $item->total_tablet_diminum,
        //             'Vitamin C (Ya/Tidak)' => $item->lebih_banyak_vit_c ? 'Ya' : 'Tidak',
        //             'Bulan' => $item->bulan . '-' . $item->tahun,
        //         ];
        //     });


        // Rata rata berdasarkan hari yang ada di bulan dikurangi dengan jumlah hari terakhir di bulan tersebut untuk
        // total tablet diminum
        return KonsumsiTtd::with('user.riwayat_hb')
            ->whereHas('user', function ($query) use ($alamat) {
                $query->where('wilayah_binaan', $alamat);
            })
            ->select([
                'user_id',
                DB::raw('YEAR(tanggal_waktu) as tahun'),
                DB::raw('MONTH(tanggal_waktu) as bulan'),
                DB::raw('SUM(COALESCE(total_tablet_diminum, 0)) as total_tablet_diminum'),
                DB::raw('SUM(COALESCE(total_tablet_diminum, 0)) / DAY(LAST_DAY(MAX(tanggal_waktu))) as rata_rata_perhari'),
                DB::raw('SUM(CASE WHEN minum_vit_c = true THEN 1 ELSE 0 END) > SUM(CASE WHEN minum_vit_c = false THEN 1 ELSE 0 END) as lebih_banyak_vit_c')
            ])
            ->whereNotNull('tanggal_waktu')
            ->groupBy('user_id', DB::raw('YEAR(tanggal_waktu)'), DB::raw('MONTH(tanggal_waktu)'))
            ->get()
            ->map(function ($item) use (&$globalIndex) {
                $globalIndex++;

                return [
                    'No' => $globalIndex,
                    'Nama Ibu Hamil' => $item->user->name ?? '-',
                    'Puskesmas' => $item->user->wilayah_binaan ?? '-',
                    'Kadar HB (g/dL) Terakhir' => $item->user->riwayat_hb->nilai_hb ?? '-',
                    'Jumlah Tablet TTD Per Hari' => number_format($item->rata_rata_perhari, 2),
                    'Total Jumlah TTD yang Dikonsumsi' => $item->total_tablet_diminum,
                    'Vitamin C (Ya/Tidak)' => $item->lebih_banyak_vit_c ? 'Ya' : 'Tidak',
                    'Bulan' => $item->bulan . '-' . $item->tahun,
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
            'Kadar HB (g/dL) Terakhir',
            'Jumlah Tablet TTD Per Hari',
            'Total Jumlah TTD yang Dikonsumsi',
            'Vitamin C (Ya/Tidak)',
            'Bulan',
        ];
    }
}
