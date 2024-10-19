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
            'total_tablet_diminum' => 'required',
            'minum_vit_c' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $user = Auth::user();

        $konsumsiTablet = KonsumsiTtd::create([
            'user_id' => $user->id,
            'tanggal_waktu' => $input['tanggal_waktu'],
            'total_tablet_diminum' => $input['total_tablet_diminum'],
            'minum_vit_c' => $input['minum_vit_c'],
        ]);

        return $this->sendResponse($konsumsiTablet, 'Data konsumsi tablet created successfully.');
    }

    public function getKonsumsiTabletUser()
    {
        $user = Auth::user();

        $konsumsiTablet = KonsumsiTtd::where('user_id', $user->id)->orderBy('tanggal_waktu', 'desc')->get();

        return $this->sendResponse($konsumsiTablet, 'Data konsumsi tablet retrieved successfully.');
    }
}
