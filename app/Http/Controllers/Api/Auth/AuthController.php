<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends BaseController
{
    public function istriLogin(Request $request)
    {
        // dd($request->user());
        $token = $request->user()->createToken($request->token_name);

        return [
            'token' => $token->plainTextToken
        ];
    }

    public function istriLoginToken(Request $request)
    {
        $provider = $request->input('provider');
        $user = $request->input('user');

        // Get User By Email
        // $existingUser = User::where('email', $user['email'])->first();

        if ($provider === 'google') {

            // dd("belum ada email");
            $validator = Validator::make($request->all(), [
                // 'user.name' => 'required',
                'user.email' => 'required|email',
            ]);
            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors());
            }

            // $user = User::create([
            //     'name' => $user['name'],
            //     'email' => $user['email'],
            // ]);

            $user = User::updateOrCreate([
                // 'name' => $user['name'],
                'email' => $user['email'],
            ]);

            $success['token'] =  $user->createToken($provider, ['*'], now()->addMonth()->subDay())->plainTextToken;
            // $success['name'] =  $user->name;

            return $this->sendResponse($success, 'User register successfully.');
        }
    }

    public function getUser()
    {
        return $this->sendResponse(Auth::user(), 'User retrieved successfully.');
    }
}
