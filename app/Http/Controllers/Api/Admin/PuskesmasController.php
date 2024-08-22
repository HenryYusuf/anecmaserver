<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Puskesmas;
use Illuminate\Http\Request;

class PuskesmasController extends BaseController
{

    public function dataPuskesmas()
    {
        $puskesmas = Puskesmas::get();
        return $this->sendResponse($puskesmas, 'Get data successfully.');
    }

    public function insertPuskesmas(Request $request)
    {
        $input = $request->all();

        $puskesmas = Puskesmas::create($input);

        return $this->sendResponse($puskesmas, 'Get data successfully.');
    }
}
