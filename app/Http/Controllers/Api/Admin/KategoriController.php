<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KategoriController extends BaseController
{
    function buildSelectOptions($categories, $parent_id = null, $depth = 0)
    {
        $options = [];
        $groupIstri = []; // Group for "Istri" (values 1–11)
        $groupSuami = []; // Group for "Suami" (values 12–13)

        foreach ($categories as $category) {
            if ($category->parent_id == $parent_id) {
                $option = '<option value="' . $category->id . '">';
                if ($depth > 0) {
                    $option .= str_repeat('&nbsp;', $depth * 2) . str_repeat('-', $depth) . ' ';
                }
                $option .= $category->nama_kategori . ' - ' . '(' . $category->gender . ')' . '</option>';

                $options[] = $option;

                $options = array_merge($options, $this->buildSelectOptions($categories, $category->id, $depth + 1));
            }
        }


        return $options;
    }

    public function dataKategori()
    {
        $results = Kategori::get();

        // $cek = $this->buildSelectOptions($results);

        // dd(implode($cek));

        return $this->sendResponse($results, 'Kategori retrieved successfully.');
    }

    public function insertKategori(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'nama_kategori' => 'required',
            'deskripsi' => 'required',
            'gender' => 'required'
        ]);

        if ($validator->fails()) {
            $this->sendError('Validation Error.', $validator->errors());
        }

        $insertdKategori = Kategori::create([
            'nama_kategori' => $input['nama_kategori'],
            'deskripsi' => $input['deskripsi'],
            'parent_id' => $input['parent_id'] ?? null,
            'gender' => $input['gender']
        ]);

        return $this->sendResponse($insertdKategori, 'Kategori created successfully.');
    }

    public function updateKategori(Request $request, $id)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'nama_kategori' => 'required',
            'deskripsi' => 'required',
            'gender' => 'required'
        ]);

        if ($validator->fails()) {
            $this->sendError('Validation Error.', $validator->errors());
        }

        $kategori = Kategori::find($id);

        $kategori->update([
            'nama_kategori' => $input['nama_kategori'],
            'deskripsi' => $input['deskripsi'],
            'parent_id' => $input['parent_id'] ?? null,
            'gender' => $input['gender']
        ]);

        return $this->sendResponse($kategori, 'Kategori updated successfully.');
    }

    public function deleteKategori($id)
    {
        $kategori = Kategori::find($id);

        $kategori->delete();

        return $this->sendResponse($kategori, 'Kategori deleted successfully.');
    }
}
