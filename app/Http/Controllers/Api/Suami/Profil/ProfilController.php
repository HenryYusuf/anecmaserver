<?php

namespace App\Http\Controllers\Api\Suami\Profil;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProfilController extends BaseController
{
    public function updatePassword(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'password' => 'required|confirmed|min:8',
            'password_confirmation' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $user = Auth::user();

        $updatedPasswordSuami = User::where('id', $user->id)->update([
            'password' => bcrypt($input['password']),
        ]);

        return $this->sendResponse($updatedPasswordSuami, 'Password updated successfully.');
    }

    public function updateDataDiri(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'usia' => 'required|numeric',
            'no_hp' => 'required',
            'tempat_tinggal_ktp' => 'required',
            'tempat_tinggal_domisili' => 'required',
            'pendidikan_terakhir' => 'required',
            'pekerjaan' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $user = Auth::user();

        $updatedSuamiProfil = User::where('id', $user->id)->update([
            'name' => $input['name'],
            'usia' => $input['usia'],
            'no_hp' => $input['no_hp'],
            'tempat_tinggal_ktp' => $input['tempat_tinggal_ktp'],
            'tempat_tinggal_domisili' => $input['tempat_tinggal_domisili'],
            'pendidikan_terakhir' => $input['pendidikan_terakhir'],
            'pekerjaan' => $input['pekerjaan'],
        ]);

        return $this->sendResponse($updatedSuamiProfil, 'Data diri updated successfully.');
    }
}
