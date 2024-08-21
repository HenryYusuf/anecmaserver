<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\KonsumsiTtd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class KonsumsiTtdController extends BaseController
{
    public function konsumsiTablet(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'tanggal_waktu' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $user = Auth::user();

        if ($request->has('minum_vit_c')) {
            $konsumsiTablet = KonsumsiTtd::create([
                'user_id' => $user->id,
                'tanggal_waktu' => $input['tanggal_waktu'],
                'minum_vit_c' => 1,
            ]);
        } else {
            $konsumsiTablet = KonsumsiTtd::create([
                'user_id' => $user->id,
                'tanggal_waktu' => $input['tanggal_waktu'],
                'minum_vit_c' => 0,
            ]);
        }

        return $this->sendResponse($konsumsiTablet, 'Data konsumsi tablet created successfully.');
    }
}
