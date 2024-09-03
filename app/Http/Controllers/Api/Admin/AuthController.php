<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\BaseController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseController
{
    public function adminRegister(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $adminUser = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => bcrypt($input['password']),
            'role' => 'admin',
        ]);

        // $petugasPuskesmas = PetugasPuskesmas::create([
        //     'user_id' => $adminUser->id,
        //     'puskesmas_id' => $input['puskesmas_id'],
        // ]);

        // $result = [$adminUser, $petugasPuskesmas];

        return $this->sendResponse($adminUser, 'Admin account created successfully.');
    }

    public function adminLogin(Request $request)
    {
        $checkUser = User::where('email', $request->email)->first();

        if (!$checkUser || $checkUser->role != "admin") {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            if ($user->role !== 'admin') {
                Auth::logout();
                return $this->sendError('Unauthorised.', ['error' => 'Only admins can login.']);
            }

            $success['token'] = $user->createToken('adminToken')->plainTextToken;
            $success['name'] = $user->name;
            return $this->sendResponse($success, 'Admin login successfully.');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }
}
