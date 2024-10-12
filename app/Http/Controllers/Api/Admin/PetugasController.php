<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\PetugasPuskesmas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    public function showPetugasPuskesmas($id)
    {
        $petugasPuskesmas = User::where('id', $id)->with('puskesmas')->first();
        return $this->sendResponse($petugasPuskesmas, 'Get data successfully.');
    }

    public function updatePetugasPuskesmas(Request $request, $id)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'email' => 'required',
            'password' => 'nullable',
            'puskesmas_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $petugasPuskesmas = User::where('user_id', $id)->first();

        $password = $petugasPuskesmas->password;

        if ($input['password']) {
            $password = bcrypt($input['password']);
        }

        $updatePetugasPuskesmas = User::where('id', $id)->update([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => $password,
            'role' => 'petugas'
        ]);

        $petugasPuskesmas = PetugasPuskesmas::where('user_id', $id)->update([
            'puskesmas_id' => $input['puskesmas_id'],
        ]);

        $result = [
            'user' => $updatePetugasPuskesmas,
            'petugas_puskesmas' => $petugasPuskesmas
        ];

        return $this->sendResponse($result, 'Data petugas puskesmas updated successfully.');
    }

    public function deletePetugasPuskesmas($id)
    {
        $petugasPuskesmas = User::where('id', $id)->delete();

        $petugasPuskesmas = PetugasPuskesmas::where('user_id', $id)->delete();

        return $this->sendResponse($petugasPuskesmas, 'Data petugas puskesmas deleted successfully.');
    }
}
