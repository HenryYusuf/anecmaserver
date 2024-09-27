<?php

namespace App\Http\Controllers\Api\Profil;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProfilController extends BaseController
{
    public function dataDiri(Request $request)
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

        $updatedUser = User::where('id', $user->id)->update([
            'name' => $input['name'],
            'usia' => $input['usia'],
            'no_hp' => $input['no_hp'],
            'tempat_tinggal_ktp' => $input['tempat_tinggal_ktp'],
            'tempat_tinggal_domisili' => $input['tempat_tinggal_domisili'],
            'pendidikan_terakhir' => $input['pendidikan_terakhir'],
            'pekerjaan' => $input['pekerjaan'],
        ]);
        return $this->sendResponse($updatedUser, 'Data diri updated successfully.');
    }

    public function dataKehamilan(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'hari_pertama_haid' => 'required',
            'wilayah_binaan' => 'required',
            'kelurahan' => 'required',
            'desa' => 'required',
            'tempat_periksa_kehamilan' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $user = Auth::user();

        $updatedUser = User::where('id', $user->id)->update([
            'hari_pertama_haid' => $input['hari_pertama_haid'],
            'wilayah_binaan' => $input['wilayah_binaan'],
            'kelurahan' => $input['kelurahan'],
            'desa' => $input['desa'],
            'tempat_periksa_kehamilan' => $input['tempat_periksa_kehamilan'],
        ]);
        return $this->sendResponse($updatedUser, 'Data kehamilan updated successfully.');
    }

    public function dataSuami(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'nama_suami' => 'required',
            'no_hp_suami' => 'required',
            'email_suami' => 'required|email',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $user = Auth::user();

        $isEmailChanged = $user->email_suami !== $input['email_suami'];

        $updatedUser = User::where('id', $user->id)->update([
            'nama_suami' => $input['nama_suami'],
            'no_hp_suami' => $input['no_hp_suami'],
            'email_suami' => $input['email_suami'],
        ]);

        if ($isEmailChanged) {
            $passwordSuami = bcrypt('suami123');

            User::create([
                'name' => $input['nama_suami'],
                'email' => $input['email_suami'],
                'password' => $passwordSuami,
                'role' => 'suami'
            ]);
        }

        return $this->sendResponse($updatedUser, 'Data suami updated successfully.');
    }
}
