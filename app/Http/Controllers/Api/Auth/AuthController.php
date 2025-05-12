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

            $success['token'] =  $user->createToken($provider, ['*'])->plainTextToken;
            // $success['name'] =  $user->name;

            return $this->sendResponse($success, 'User register successfully.');
        }
    }

    public function getUser()
    {
        $user = Auth::user();

        $userData = User::where('email', $user->email)->with('resikoAnemiaTerbaru', 'riwayat_hb')->first();

        $hariPertamaHaid = $userData->hari_pertama_haid;
        $startDate = Carbon::create($hariPertamaHaid);
        $currentDate = Carbon::now();

        $weekPassed = floor($startDate->diffInWeeks($currentDate));

        $results = [
            'user' => $userData,
            'usia_kehamilan' => $weekPassed
        ];

        return $this->sendResponse($results, 'User retrieved successfully.');
    }

    public function suamiLogin(Request $request)
    {
        $checkUser = User::where('email', $request->email)->orWhere('no_hp', $request->email)->first();

        if (!$checkUser || $checkUser->role != "suami") {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }

        if (Auth::attempt(['email' => $checkUser->email, 'password' => $request->password])) {
            $user = Auth::user();

            if ($user->role !== 'suami') {
                Auth::logout();
                return $this->sendError('Unauthorised.', ['error' => 'Only suami can login.']);
            }

            $success['token'] = $user->createToken('suamiToken')->plainTextToken;
            $success['name'] = $user->name;
            return $this->sendResponse($success, 'Suami login successfully.');
        } else {
            return $this->sendError('Unauthorised.', ['error' => 'Unauthorised']);
        }
    }

    public function getUserSuami()
    {
        $user = Auth::user();

        $wife = User::where('email', $user->email)->with('wives')->first();

        $wifeEmail = $wife->wives->first()->email;

        $dataWife = User::where('email', $wifeEmail)->with('resikoAnemia', 'riwayat_hb')->first();

        $hariPertamaHaid = $dataWife->hari_pertama_haid;
        $startDate = Carbon::create($hariPertamaHaid);
        $currentDate = Carbon::now();

        $weekPassed = floor($startDate->diffInWeeks($currentDate));

        $results = [
            'user' => $user,
            'dataWife' => $dataWife,
            "usia_kehamilan_istri" => $weekPassed
        ];
        // $results = User::where('email')


        return $this->sendResponse($results, 'User retrieved successfully.');
    }
}
