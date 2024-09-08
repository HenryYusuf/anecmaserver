<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Api\BaseController;
use App\Models\JurnalMakan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class JurnalMakanController extends BaseController
{
    public function getJurnalMakan()
    {
        $user = Auth::user();
        $checkJurnalMakanUser = JurnalMakan::where('user_id', $user->id)->whereDate('tanggal', now())->first();

        if ($checkJurnalMakanUser) {
            return $this->sendResponse($checkJurnalMakanUser, 'Jurnal Makan found.');
        } else {
            return $this->sendError('Error', 'Jurnal Makan not found.');
        }
    }

    public function insertJurnalMakan(Request $request)
    {
        $input = $request->all();

        if ($input['jam_makan'] == "sarapan") {
            $validator = Validator::make($input, [
                'sarapan_karbohidrat' => 'required|numeric',
                'sarapan_lauk_hewani' => 'required|numeric',
                'sarapan_lauk_nabati' => 'required|numeric',
                'sarapan_sayur' => 'required|numeric',
                'sarapan_buah' => 'required|numeric',
                'total_kalori' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors());
            }

            $user = Auth::user();

            $checkJurnalMakanUser = JurnalMakan::where('user_id', $user->id)->whereDate('tanggal', now())->first();

            if ($checkJurnalMakanUser) {
                $checkJurnalMakanUser->update([
                    'sarapan_karbohidrat' => $input['sarapan_karbohidrat'],
                    'sarapan_lauk_hewani' => $input['sarapan_lauk_hewani'],
                    'sarapan_lauk_nabati' => $input['sarapan_lauk_nabati'],
                    'sarapan_sayur' => $input['sarapan_sayur'],
                    'sarapan_buah' => $input['sarapan_buah'],
                    'total_kalori' => $input['total_kalori'],
                ]);
            } else {
                $checkJurnalMakanUser = JurnalMakan::create(
                    [
                        'user_id' => $user->id,
                        'tanggal' => now(),
                        'sarapan_karbohidrat' => $input['sarapan_karbohidrat'],
                        'sarapan_lauk_hewani' => $input['sarapan_lauk_hewani'],
                        'sarapan_lauk_nabati' => $input['sarapan_lauk_nabati'],
                        'sarapan_sayur' => $input['sarapan_sayur'],
                        'sarapan_buah' => $input['sarapan_buah'],
                        'total_kalori' => $input['total_kalori'],
                    ]);
            }

            return $this->sendResponse($checkJurnalMakanUser, 'Jurnal Makan created or updated successfully.');

        } else if ($input['jam_makan'] == "makan_siang") {
            $validator = Validator::make($input, [
                'makan_siang_karbohidrat' => 'required|numeric',
                'makan_siang_lauk_hewani' => 'required|numeric',
                'makan_siang_lauk_nabati' => 'required|numeric',
                'makan_siang_sayur' => 'required|numeric',
                'makan_siang_buah' => 'required|numeric',
                'total_kalori' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors());
            }

            $user = Auth::user();

            $checkJurnalMakanUser = JurnalMakan::where('user_id', $user->id)->whereDate('tanggal', now())->first();

            if ($checkJurnalMakanUser) {
                $checkJurnalMakanUser->update([
                    'makan_siang_karbohidrat' => $input['makan_siang_karbohidrat'],
                    'makan_siang_lauk_hewani' => $input['makan_siang_lauk_hewani'],
                    'makan_siang_lauk_nabati' => $input['makan_siang_lauk_nabati'],
                    'makan_siang_sayur' => $input['makan_siang_sayur'],
                    'makan_siang_buah' => $input['makan_siang_buah'],
                    'total_kalori' => $input['total_kalori'],
                ]);
            } else {
                $checkJurnalMakanUser = JurnalMakan::create(
                    [
                        'user_id' => $user->id,
                        'tanggal' => now(),
                        'makan_siang_karbohidrat' => $input['makan_siang_karbohidrat'],
                        'makan_siang_lauk_hewani' => $input['makan_siang_lauk_hewani'],
                        'makan_siang_lauk_nabati' => $input['makan_siang_lauk_nabati'],
                        'makan_siang_sayur' => $input['makan_siang_sayur'],
                        'makan_siang_buah' => $input['makan_siang_buah'],
                        'total_kalori' => $input['total_kalori'],
                    ]);
            }

            return $this->sendResponse($checkJurnalMakanUser, 'Jurnal Makan created or updated successfully.');
        } else if ($input['jam_makan'] == "makan_malam") {
            $validator = Validator::make($input, [
                'makan_malam_karbohidrat' => 'required|numeric',
                'makan_malam_lauk_hewani' => 'required|numeric',
                'makan_malam_lauk_nabati' => 'required|numeric',
                'makan_malam_sayur' => 'required|numeric',
                'makan_malam_buah' => 'required|numeric',
                'total_kalori' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                return $this->sendError('Validation Error.', $validator->errors());
            }

            $user = Auth::user();

            $checkJurnalMakanUser = JurnalMakan::where('user_id', $user->id)->whereDate('tanggal', now())->first();

            if ($checkJurnalMakanUser) {
                $checkJurnalMakanUser->update([
                    'makan_malam_karbohidrat' => $input['makan_malam_karbohidrat'],
                    'makan_malam_lauk_hewani' => $input['makan_malam_lauk_hewani'],
                    'makan_malam_lauk_nabati' => $input['makan_malam_lauk_nabati'],
                    'makan_malam_sayur' => $input['makan_malam_sayur'],
                    'makan_malam_buah' => $input['makan_malam_buah'],
                    'total_kalori' => $input['total_kalori'],
                ]);
            } else {
                $checkJurnalMakanUser = JurnalMakan::create(
                    [
                        'user_id' => $user->id,
                        'tanggal' => now(),
                        'makan_malam_karbohidrat' => $input['makan_malam_karbohidrat'],
                        'makan_malam_lauk_hewani' => $input['makan_malam_lauk_hewani'],
                        'makan_malam_lauk_nabati' => $input['makan_malam_lauk_nabati'],
                        'makan_malam_sayur' => $input['makan_malam_sayur'],
                        'makan_malam_buah' => $input['makan_malam_buah'],
                        'total_kalori' => $input['total_kalori'],
                    ]);
            }

            return $this->sendResponse($checkJurnalMakanUser, 'Jurnal Makan created or updated successfully.');
        }
    }
}
