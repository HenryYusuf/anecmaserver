<?php

namespace App\Http\Controllers\Api\Petugas;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends BaseController
{
    public function petugasLogin(Request $request)
    {
        $checkUser = User::where('email', $request->email)->first();

        if (!$checkUser || $checkUser->role != "petugas") {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user()->load('puskesmas');
            $userPuskesmas = $user->puskesmas->first()->nama_puskesmas;
            $userAlamatPuskesmas = $user->puskesmas->first()->alamat;

            if ($user->role !== 'petugas') {
                Auth::logout();
                return $this->sendError('Unauthorised.', ['error' => 'Only petugas can login.']);
            }

            $success['token'] = $user->createToken('petugasToken')->plainTextToken;
            $success['name'] = $user->name;
            $success['puskesmas'] = $userPuskesmas;
            $success['alamat_puskesmas'] = $userAlamatPuskesmas;
            return $this->sendResponse($success, 'Petugas login successfully.');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }

    public function getUser()
    {
        $user = Auth::user();

        $userData = User::where('email', $user->email)->with('puskesmas')->first();

        $results = [
            'user' => $userData,
        ];

        return $this->sendResponse($results, 'User retrieved successfully.');
    }
}
