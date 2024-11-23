<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Edukasi;
use App\Models\Kategori;
use App\Models\KategoriEdukasi;
use Illuminate\Http\Request;

class KategoriEdukasiController extends BaseController
{
    public function dataKategoriEdukasi()
    {
        // Edukasi untuk anemia tinggi
        $dataAnemiaTinggi = Kategori::with(['kategori_child.edukasi'])->whereNull('parent_id')->where('gender', 'istri')->limit(2)->get();

        // Edukasi untuk anemia rendah
        $dataAnemiaRendah = Kategori::with('edukasi')->has('edukasi')->whereNull('parent_id')->where('gender', 'istri')->get();

        return $this->sendResponse($dataAnemiaTinggi, 'Kategori Edukasi retrieved successfully.');
    }
}
