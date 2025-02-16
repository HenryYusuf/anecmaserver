<?php

namespace App\Http\Controllers\Api\Petugas;

use App\Exports\PetugasDashboardExport;
use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\ResikoAnemia;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class DashboardController extends BaseController
{
    public function hitungData()
    {
        $user = Auth::user()->load('puskesmas');

        $alamat = $user->puskesmas->first()->alamat;

        $jumlahIbuHamil = User::where('role', 'istri')->where('wilayah_binaan', $alamat)->count();

        $jumlahIbuHamilAnemiaRendah = User::where('role', 'istri')
            ->whereHas('resikoAnemia', function ($query) {
                $query->latest()->take(1)->where('resiko', 'rendah');
            })->where('wilayah_binaan', $alamat)->count();

        $jumlahIbuHamilAnemiaTinggi = User::where('role', 'istri')
            ->whereHas('resikoAnemia', function ($query) {
                $query->latest()->take(1)->where('resiko', 'tinggi');
            })->where('wilayah_binaan', $alamat)->count();

        $averageKonsumsiTTD = ResikoAnemia::whereHas('user', function ($query) use ($alamat) {
            $query->where('wilayah_binaan', $alamat);
        })->avg('konsumsi_ttd_7hari');

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
        $user = Auth::user()->load('puskesmas');

        $alamat = $user->puskesmas->first()->alamat;

        $data = User::where('role', 'istri')->where('wilayah_binaan', $alamat)->with('resikoAnemia')->get();

        return $this->sendResponse($data, 'Get data successfully.');
    }

    public function exportDataToExcel()
    {
        try {
            $user = Auth::user()->load('puskesmas');

            $alamat = $user->puskesmas->first()->alamat;

            $data = [
                'ibu_hamil' => User::where('role', 'istri')->where('wilayah_binaan', $alamat)->count(),
                'ibu_hamil_anemia_rendah' => User::where('role', 'istri')
                    ->whereHas('resikoAnemia', function ($query) {
                        $query->latest()->take(1)->where('resiko', 'rendah');
                    })->where('wilayah_binaan', $alamat)->count(),
                'ibu_hamil_anemia_tinggi' => User::where('role', 'istri')
                    ->whereHas('resikoAnemia', function ($query) {
                        $query->latest()->take(1)->where('resiko', 'tinggi');
                    })->where('wilayah_binaan', $alamat)->count(),
                'rata_rata_konsumsi_ttd' => ResikoAnemia::whereHas('user', function ($query) use ($alamat) {
                    $query->where('wilayah_binaan', $alamat);
                })->avg('konsumsi_ttd_7hari')
            ];

            // Pass data to export class
            return Excel::download(new PetugasDashboardExport($data), 'dashboard_data.xlsx');
        } catch (\Exception $e) {
            return response()->json(['message' => 'Export failed: ' . $e->getMessage()], 500);
        }
    }
}
