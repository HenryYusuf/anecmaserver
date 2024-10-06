<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Edukasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EdukasiController extends BaseController
{
    public function dataEdukasi()
    {
        $results = Edukasi::orderBy('created_at', 'desc')->all();

        return $this->sendResponse($results, 'Edukasi retrieved successfully.');
    }

    public function insertEdukasi(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'judul' => 'required',
            'konten' => 'required',
            'jenis' => 'required',
            'kategori' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $user = Auth::user();

        $edukasi = Edukasi::create([
            'created_by' => $user->id,
            'judul' => $input['judul'],
            'konten' => $input['konten'],
            'jenis' => $input['jenis'],
            'kategori' => $input['kategori'],
        ]);

        return $this->sendResponse($edukasi, 'Edukasi inserted successfully.');
    }

    public function showEdukasi($id)
    {
        $edukasi = Edukasi::find($id);

        return $this->sendResponse($edukasi, 'Edukasi retrieved successfully.');
    }

    public function updateEdukasi(Request $request, $id)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'judul' => 'required',
            'konten' => 'required',
            'jenis' => 'required',
            'kategori' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $edukasi = Edukasi::find($id);

        $edukasi->update([
            'judul' => $input['judul'],
            'konten' => $input['konten'],
            'jenis' => $input['jenis'],
            'kategori' => $input['kategori'],
        ]);

        return $this->sendResponse($edukasi, 'Edukasi updated successfully.');
    }

    public function deleteEdukasi($id)
    {
        $edukasi = Edukasi::find($id);

        $edukasi->delete();

        return $this->sendResponse($edukasi, 'Edukasi deleted successfully.');
    }
}
