<?php

namespace App\Http\Controllers\Api\Admin;

use App\Exports\DashboardDataExport;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\ResikoAnemia;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DashboardController extends BaseController
{
    public function hitungData()
    {
        $jumlahIbuHamil = User::where('role', 'istri')->count();

        $jumlahIbuHamilAnemiaRendah = User::where('role', 'istri')
            ->whereHas('resikoAnemia', function ($query) {
                $query->latest()->take(1)->where('resiko', 'rendah');
            })->count();

        $jumlahIbuHamilAnemiaTinggi = User::where('role', 'istri')
            ->whereHas('resikoAnemia', function ($query) {
                $query->latest()->take(1)->where('resiko', 'tinggi');
            })->count();

        $averageKonsumsiTTD = ResikoAnemia::avg('konsumsi_ttd_7hari');

        $data = [
            'ibu_hamil' => $jumlahIbuHamil,
            'ibu_hamil_anemia_rendah' => $jumlahIbuHamilAnemiaRendah,
            'ibu_hamil_anemia_tinggi' => $jumlahIbuHamilAnemiaTinggi,
            'rata_rata_konsumsi_ttd' => $averageKonsumsiTTD
        ];
        return $this->sendResponse($data, 'Get data successfully.');
    }

    public function dataTerbaru()
    {
        $data = User::where('role', 'istri')->with('resikoAnemia')->get();

        return $this->sendResponse($data, 'Get data successfully.');
    }

    public function exportDataToExcel()
    {
        try {
            $data = [
                'ibu_hamil' => User::where('role', 'istri')->count(),
                'ibu_hamil_anemia_rendah' => User::where('role', 'istri')
                    ->whereHas('resikoAnemia', function ($query) {
                        $query->latest()->take(1)->where('resiko', 'rendah');
                    })->count(),
                'ibu_hamil_anemia_tinggi' => User::where('role', 'istri')
                    ->whereHas('resikoAnemia', function ($query) {
                        $query->latest()->take(1)->where('resiko', 'tinggi');
                    })->count(),
                'rata_rata_konsumsi_ttd' => ResikoAnemia::avg('konsumsi_ttd_7hari'),
            ];

            // Pass data to export class
            return Excel::download(new DashboardDataExport($data), 'dashboard_data.xlsx');
        } catch (\Exception $e) {
            return response()->json(['message' => 'Export failed: ' . $e->getMessage()], 500);
        }
    }
}
