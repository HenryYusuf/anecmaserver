<?php

namespace App\Http\Controllers\Api\Edukasi;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Edukasi;
use Illuminate\Http\Request;

class EdukasiController extends BaseController
{
    public function getEdukasi()
    {
        $results = Edukasi::all();

        return $this->sendResponse($results, 'Edukasi retrieved successfully.');
    }
}
