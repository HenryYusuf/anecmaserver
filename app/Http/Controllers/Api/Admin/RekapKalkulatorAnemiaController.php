<?php

namespace App\Http\Controllers\Api\Admin;

use App\Exports\RekapKalkulatorAnemiaExport;
use App\Http\Controllers\Api\BaseController;
use App\Models\ResikoAnemia;
use Maatwebsite\Excel\Facades\Excel;

class RekapKalkulatorAnemiaController extends BaseController
{
    public function getRekapKalkulatorAnemia()
    {
        $results = ResikoAnemia::with('user')->get();

        return $this->sendResponse($results, 'Rekap Kalkulator Anemia retrieved successfully.');
    }

    public function exportRekapKalkulatorAnemia()
    {
        return Excel::download(new RekapKalkulatorAnemiaExport, 'rekap_kalkulator_anemia.xlsx');
    }
}
