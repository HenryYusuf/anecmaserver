<?php

namespace App\Http\Controllers\Api\Suami\Edukasi;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Edukasi;
use App\Models\Kategori;
use Illuminate\Http\Request;

class EdukasiController extends BaseController
{
    public function getEdukasi()
    {
        $dataEdukasi = Kategori::with('edukasi')->has('edukasi')->whereNull('parent_id')->where('gender', 'suami')->get();

        return $this->sendResponse($dataEdukasi, 'Kategori Edukasi retrieved successfully.');
    }

    public function showEdukasi($id)
    {
        $edukasi = Edukasi::find($id);

        return $this->sendResponse($edukasi, 'Edukasi retrieved successfully.');
    }
}
