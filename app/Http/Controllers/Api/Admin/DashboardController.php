<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\ResikoAnemia;
use App\Models\User;
use Illuminate\Http\Request;

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
}
