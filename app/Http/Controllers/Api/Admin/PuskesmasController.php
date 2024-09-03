<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\Puskesmas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

        $validator = Validator::make($input, [
            'nama_puskesmas' => 'required',
            'alamat' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $puskesmas = Puskesmas::create([
            'nama_puskesmas' => $input['nama_puskesmas'],
            'alamat' => $input['alamat'],
        ]);

        return $this->sendResponse($puskesmas, 'Create puskesmas data successfully.');
    }

    public function showPuskesmas($id)
    {
        $puskesmas = Puskesmas::where('id', $id)->first();
        return $this->sendResponse($puskesmas, 'Get puskesmas data successfully.');
    }

    public function updatePuskesmas(Request $request, $id)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'nama_puskesmas' => 'required',
            'alamat' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $updatePuskesmas = Puskesmas::where('id', $id)->update([
            'nama_puskesmas' => $input['nama_puskesmas'],
            'alamat' => $input['alamat'],
        ]);

        return $this->sendResponse($updatePuskesmas, 'Update puskesmas data successfully.');
    }

    public function deletePuskesmas($id)
    {
        $deletePuskesmas = Puskesmas::where('id', $id)->delete();
        return $this->sendResponse($deletePuskesmas, 'Delete puskesmas data successfully.');
    }
}
