<?php

namespace App\Exports;

use App\Models\User;
use Carbon\Carbon;
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

        return User::with(['konsumsi_ttd'])
            ->where('role', 'istri')
            ->get()
            ->map(function ($user) use (&$globalIndex) {
                $globalIndex++;

                $konsumsiTtdByMonth = $user->konsumsi_ttd
                    ->groupBy(function ($ttd) {
                        return Carbon::parse($ttd->created_at)->format('Y-m');
                    });

                $totalKonsumsi = $konsumsiTtdByMonth->map(function ($items, $month) {
                    return [
                        'month' => Carbon::parse($month)->format('F'), 
                        'total' => $items->sum('total_tablet_diminum'),
                        'average' => round($items->avg('total_tablet_diminum'), 0),
                        'vitamin_c' => $items->avg('minum_vit_c') >= 0.5 ? 'Ya' : 'Tidak',
                    ];
                });

                $rows = [];
                foreach ($totalKonsumsi as $data) {
                    $rows[] = [
                        'no' => $globalIndex,
                        'name' => $user->name,
                        'jumlah_ttd_perhari' => $data['average'] ?? '-',
                        'jumlah_ttd_dikonsumsi' => $data['total'] ?? '-',
                        'vitamin_c' => $data['vitamin_c'] ?? 'Tidak',
                        'bulan' => $data['month'] ?? '-',
                    ];
                }

                return $rows;
            })
            ->collapse();
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
            'Jumlah Tablet TTD per Hari',
            'Total Jumlah TTD yang Dikonsumsi',
            'Vitamin C (Ya/Tidak)',
            'Bulan',
        ];
    }
 
}
