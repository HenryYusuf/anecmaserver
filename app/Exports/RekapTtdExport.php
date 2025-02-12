<?php

namespace App\Exports;

use App\Models\KonsumsiTtd;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RekapTtdExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $globalIndex = 0;

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


    // private function getKonsumsiTtdData(User $user)
    // {
    //     // Ambil data konsumsi TTD berdasarkan user
    //     $konsumsiTtds = $user->konsumsi_ttd()
    //         ->where('user_id', $user->id)
    //         ->get()
    //         ->groupBy(function ($item) {
    //             return Carbon::parse($item->tanggal_waktu)->format('F'); // Kelompokkan berdasarkan bulan
    //         });


    //     $data = [];

    //     // Proses data per bulan
    //     foreach ($konsumsiTtds as $bulan => $records) {
    //         // Ambil data kategori 1 dan 2
    //         $kategori1 = $records->where('total_tablet_diminum', 1);
    //         $kategori2 = $records->where('total_tablet_diminum', 2);

    //         $totalVitaminC1 = $kategori1->sum('minum_vit_c');
    //         $totalVitaminC2 = $kategori2->sum('minum_vit_c');

    //         // Ambil tanggal terakhir untuk kategori 1 dan kategori 2 dalam bulan tersebut
    //         $tanggalTerakhirKategori1 = $kategori1->sortByDesc('tanggal_waktu')->first();
    //         $tanggalTerakhirKategori2 = $kategori2->sortByDesc('tanggal_waktu')->first();

    //         // Ambil kadar HB untuk masing-masing kategori berdasarkan tanggal terakhir dalam bulan yang sama
    //         $kadarHbKategori1 = $this->getLatestHbInMonth($user, $tanggalTerakhirKategori1, $bulan);
    //         $kadarHbKategori2 = $this->getLatestHbInMonth($user, $tanggalTerakhirKategori2, $bulan);

    //         // Masukkan ke dalam data
    //         if ($kategori1->count() > 0) {
    //             $data[] = [
    //                 'Nama Ibu Hamil' => $user->name,
    //                 'Bulan' => $bulan,
    //                 'Kadar HB (g/dL)' => $kadarHbKategori1 ?? '-',
    //                 'Kategori Tablet TTD Per Hari' => 1,
    //                 'Total Jumlah TTD yang Dikonsumsi' => $kategori1->count(),
    //                 'Total Vitamin C yang Dikonsumsi' => $totalVitaminC1,
    //             ];
    //         }
    //         if ($kategori2->count() > 0) {
    //             $data[] = [
    //                 'Nama Ibu Hamil' => $user->name,
    //                 'Bulan' => $bulan,
    //                 'Kadar HB (g/dL)' => $kadarHbKategori2 ?? '-',
    //                 'Kategori Tablet TTD Per Hari' => 2,
    //                 'Total Jumlah TTD yang Dikonsumsi' => $kategori2->count(),
    //                 'Total Vitamin C yang Dikonsumsi' => $totalVitaminC2,
    //             ];
    //         }
    //     }

    //     return collect($data);
    // }

    // private function getLatestHbInMonth(User $user, $kategori, $bulan)
    // {
    //     // Cek apakah kategori tidak kosong
    //     if ($kategori) {
    //         // Ambil kadar HB berdasarkan tanggal terakhir dalam bulan yang sama
    //         $kadarHb = $user->cekHb()
    //             ->whereMonth('created_at', Carbon::parse($kategori->tanggal_waktu)->month)
    //             ->whereYear('created_at', Carbon::parse($kategori->tanggal_waktu)->year)
    //             ->latest()
    //             ->first();

    //         // Pastikan data ditemukan dan ada hasil HB
    //         return $kadarHb ? $kadarHb->nilai_hb : null;
    //     }

    //     return null; // Jika tidak ada kategori, kembalikan null
    // }

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
