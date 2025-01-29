<?php

namespace App\Exports;

use App\Models\User;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RekapGiziExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $globalIndex = 0;

        return User::with(['jurnal_makan'])
            ->where('role', 'istri')
            ->get()
            ->flatMap(function ($user) use (&$globalIndex) {
                // Validasi apakah jurnal makan ada
                if ($user->jurnal_makan && $user->jurnal_makan->isNotEmpty()) {
                    return $user->jurnal_makan->flatMap(function ($jurnal_makan) use ($user, &$globalIndex) {
                        $tanggal = $jurnal_makan->created_at
                            ? Carbon::parse($jurnal_makan->created_at)->format('d/m/Y')
                            : '-';

                        // Buat baris untuk setiap jenis karbohidrat
                        $rows = [];

                        // Tambahkan sarapan jika tersedia
                        if ($jurnal_makan->sarapan_karbohidrat) {
                            $globalIndex++;
                            $rows[] = [
                                'No' => $globalIndex,
                                'Nama Ibu Hamil' => $user->name,
                                'Tanggal Input' => $tanggal,
                                'Keterangan' => 'Sarapan',
                                'Karbohidrat' => $jurnal_makan->sarapan_karbohidrat,
                                'Lauk Hewani' => $jurnal_makan->sarapan_lauk_hewani,
                                'Lauk Nabati' => $jurnal_makan->sarapan_lauk_nabati,
                                'Sayur' => $jurnal_makan->sarapan_sayur,
                                'Buah' => $jurnal_makan->sarapan_buah,
                                'Hasil Gizi' => $jurnal_makan->hasil_gizi,
                            ];
                        }

                        // Tambahkan makan siang jika tersedia
                        if ($jurnal_makan->makan_siang_karbohidrat) {
                            $globalIndex++;
                            $rows[] = [
                                'No' => $globalIndex,
                                'Nama Ibu Hamil' => $user->name,
                                'Tanggal Input' => $tanggal,
                                'Keterangan' => 'Makan Siang',
                                'Karbohidrat' => $jurnal_makan->makan_siang_karbohidrat,
                                'Lauk Hewani' => $jurnal_makan->makan_siang_lauk_hewani,
                                'Lauk Nabati' => $jurnal_makan->makan_siang_lauk_nabati,
                                'Sayur' => $jurnal_makan->makan_siang_sayur,
                                'Buah' => $jurnal_makan->makan_siang_buah,
                                'Hasil Gizi' => $jurnal_makan->hasil_gizi,
                            ];
                        }

                        // Tambahkan makan malam jika tersedia
                        if ($jurnal_makan->makan_malam_karbohidrat) {
                            $globalIndex++;
                            $rows[] = [
                                'No' => $globalIndex,
                                'Nama Ibu Hamil' => $user->name,
                                'Tanggal Input' => $tanggal,
                                'Keterangan' => 'Makan Malam',
                                'Karbohidrat' => $jurnal_makan->makan_malam_karbohidrat,
                                'Lauk Hewani' => $jurnal_makan->makan_malam_lauk_hewani,
                                'Lauk Nabati' => $jurnal_makan->makan_malam_lauk_nabati,
                                'Sayur' => $jurnal_makan->makan_malam_sayur,
                                'Buah' => $jurnal_makan->makan_malam_buah,
                                'Hasil Gizi' => $jurnal_makan->hasil_gizi,
                            ];
                        }

                        return $rows;
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
            'Tanggal Input',
            'Waktu',
            'Karbohidrat (Porsi)',
            'Lauk Hewani (Porsi)',
            'Lauk Nabati (Porsi)',
            'Sayur (Porsi)',
            'Buah (Porsi)',
            'Konsumsi Gizi',
        ];
    }
}
