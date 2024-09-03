<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\PetugasPuskesmas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PetugasController extends BaseController
{
    public function dataPetugasPuskesmas()
    {
        $petugasPuskesmas = User::where('role', 'petugas')->with('puskesmas')->get();
        return $this->sendResponse($petugasPuskesmas, 'Get data successfully.');
    }

    public function insertPetugasPuskesmas(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'puskesmas_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $accountPetugasPuskesmas = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => bcrypt($input['password']),
            'role' => 'petugas'
        ]);

        $petugasPuskesmas = PetugasPuskesmas::create([
            'user_id' => $accountPetugasPuskesmas->id,
            'puskesmas_id' => $input['puskesmas_id'],
        ]);

        $result = [
            'user' => $accountPetugasPuskesmas,
            'petugas_puskesmas' => $petugasPuskesmas
        ];

        return $this->sendResponse($result, 'Data petugas puskesmas created successfully.');
    }
}
