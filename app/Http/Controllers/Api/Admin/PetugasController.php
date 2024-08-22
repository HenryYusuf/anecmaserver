<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class PetugasController extends BaseController
{
    public function dataPetugasPuskesmas()
    {
        $petugasPuskesmas = User::where('role', 'petugas')->with('puskesmas')->get();
        return $this->sendResponse($petugasPuskesmas, 'Get data successfully.');
    }
}
