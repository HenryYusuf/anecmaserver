<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Api\BaseController;
use App\Models\JurnalMakan;
use Carbon\Carbon;
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

    public function getLatestJurnalMakan()
    {
        $user = Auth::user();
        $checkJurnalMakanUser = JurnalMakan::where('user_id', $user->id)->latest()->first();

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
                    ]
                );
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
                    ]
                );
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
                    ]
                );
            }

            return $this->sendResponse($checkJurnalMakanUser, 'Jurnal Makan created or updated successfully.');
        }
    }

    public function insertSarapan(Request $request)
    {
        $input = $request->all();

        // Validasi input
        $validator = Validator::make($input, [
            'sarapan_karbohidrat' => 'required',
            'sarapan_lauk_hewani' => 'required',
            'sarapan_lauk_nabati' => 'required',
            'sarapan_sayur' => 'required',
            'sarapan_buah' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $user = Auth::user();

        // Cek usia kehamilan berdasar trisemester
        $hariPertamaHaid = $user->hari_pertama_haid;
        $startDate = Carbon::create($hariPertamaHaid);
        // $startDate = Carbon::create(2023, 9, 1);
        $currentDate = Carbon::now();
        $weekPassed = floor($startDate->diffInWeeks($currentDate));

        // Cek apakah ada riwayat mengisi jurnal makan hari ini
        $checkJurnalMakanUser = JurnalMakan::where('user_id', $user->id)->whereDate('tanggal', now())->first();

        // dd($checkJurnalMakanUser);

        $total_kalori = 0;
        $total_kalori_karbohidrat = 0;
        $total_kalori_lauk_hewani = 0;
        $total_kalori_lauk_nabati = 0;
        $total_kalori_sayur = 0;
        $total_kalori_buah = 0;
        $hasil_gizi = "";

        if ($weekPassed <= 12) {
            if ($checkJurnalMakanUser) {
                // dd("sudah pernah isi 5 porsi");
                $total_kalori = $input['sarapan_karbohidrat'] +
                    $input['sarapan_lauk_hewani'] +
                    $input['sarapan_lauk_nabati'] +
                    $input['sarapan_sayur'] +
                    $input['sarapan_buah'] +
                    $checkJurnalMakanUser->makan_siang_karbohidrat +
                    $checkJurnalMakanUser->makan_siang_lauk_hewani +
                    $checkJurnalMakanUser->makan_siang_lauk_nabati +
                    $checkJurnalMakanUser->makan_siang_sayur +
                    $checkJurnalMakanUser->makan_siang_buah +
                    $checkJurnalMakanUser->makan_malam_karbohidrat +
                    $checkJurnalMakanUser->makan_malam_lauk_hewani +
                    $checkJurnalMakanUser->makan_malam_lauk_nabati +
                    $checkJurnalMakanUser->makan_malam_sayur +
                    $checkJurnalMakanUser->makan_malam_buah;

                $total_kalori_karbohidrat = $input['sarapan_karbohidrat'] + $checkJurnalMakanUser->makan_siang_karbohidrat + $checkJurnalMakanUser->makan_malam_karbohidrat;
                $total_kalori_lauk_hewani = $input['sarapan_lauk_hewani'] + $checkJurnalMakanUser->makan_siang_lauk_hewani + $checkJurnalMakanUser->makan_malam_lauk_hewani;
                $total_kalori_lauk_nabati = $input['sarapan_lauk_nabati'] + $checkJurnalMakanUser->makan_siang_lauk_nabati + $checkJurnalMakanUser->makan_malam_lauk_nabati;
                $total_kalori_sayur = $input['sarapan_sayur'] + $checkJurnalMakanUser->makan_siang_sayur + $checkJurnalMakanUser->makan_malam_sayur;
                $total_kalori_buah = $input['sarapan_buah'] + $checkJurnalMakanUser->makan_siang_buah + $checkJurnalMakanUser->makan_malam_buah;

                if ($total_kalori_karbohidrat < 5) {
                    $hasil_gizi = "Gizi Tidak Seimbang";
                } else {
                    $hasil_gizi = "Gizi Seimbang";
                }
            } else {
                // dd("Belum pernah isi 5 porsi");
                if ($input['sarapan_karbohidrat'] < 5) {
                    $hasil_gizi = "Gizi Tidak Seimbang";
                } else {
                    $hasil_gizi = "Gizi Seimbang";
                }
            }
        } else if ($weekPassed > 12) {
            if ($checkJurnalMakanUser) {
                // dd("sudah pernah isi 6 porsi");
                $total_kalori = $input['sarapan_karbohidrat'] +
                    $input['sarapan_lauk_hewani'] +
                    $input['sarapan_lauk_nabati'] +
                    $input['sarapan_sayur'] +
                    $input['sarapan_buah'] +
                    $checkJurnalMakanUser->makan_siang_karbohidrat +
                    $checkJurnalMakanUser->makan_siang_lauk_hewani +
                    $checkJurnalMakanUser->makan_siang_lauk_nabati +
                    $checkJurnalMakanUser->makan_siang_sayur +
                    $checkJurnalMakanUser->makan_siang_buah +
                    $checkJurnalMakanUser->makan_malam_karbohidrat +
                    $checkJurnalMakanUser->makan_malam_lauk_hewani +
                    $checkJurnalMakanUser->makan_malam_lauk_nabati +
                    $checkJurnalMakanUser->makan_malam_sayur +
                    $checkJurnalMakanUser->makan_malam_buah;

                $total_kalori_karbohidrat = $input['sarapan_karbohidrat'] + $checkJurnalMakanUser->makan_siang_karbohidrat + $checkJurnalMakanUser->makan_malam_karbohidrat;
                $total_kalori_lauk_hewani = $input['sarapan_lauk_hewani'] + $checkJurnalMakanUser->makan_siang_lauk_hewani + $checkJurnalMakanUser->makan_malam_lauk_hewani;
                $total_kalori_lauk_nabati = $input['sarapan_lauk_nabati'] + $checkJurnalMakanUser->makan_siang_lauk_nabati + $checkJurnalMakanUser->makan_malam_lauk_nabati;
                $total_kalori_sayur = $input['sarapan_sayur'] + $checkJurnalMakanUser->makan_siang_sayur + $checkJurnalMakanUser->makan_malam_sayur;
                $total_kalori_buah = $input['sarapan_buah'] + $checkJurnalMakanUser->makan_siang_buah + $checkJurnalMakanUser->makan_malam_buah;

                if ($total_kalori_karbohidrat < 6) {
                    $hasil_gizi = "Gizi Tidak Seimbang";
                } else {
                    $hasil_gizi = "Gizi Seimbang";
                }
            } else {
                // dd("Belum pernah isi 6 porsi");
                if ($input['sarapan_karbohidrat'] < 6) {
                    $hasil_gizi = "Gizi Tidak Seimbang";
                } else {
                    $hasil_gizi = "Gizi Seimbang";
                }
            }
        }

        if ($checkJurnalMakanUser) {
            // dd("Gacor");
            $checkJurnalMakanUser->update([
                'usia_kehamilan' => $weekPassed,
                'tanggal' => now(),
                'sarapan_karbohidrat' => $input['sarapan_karbohidrat'],
                'sarapan_lauk_hewani' => $input['sarapan_lauk_hewani'],
                'sarapan_lauk_nabati' => $input['sarapan_lauk_nabati'],
                'sarapan_sayur' => $input['sarapan_sayur'],
                'sarapan_buah' => $input['sarapan_buah'],
                'total_kalori_karbohidrat' => $total_kalori_karbohidrat,
                'total_kalori_lauk_hewani' => $total_kalori_lauk_hewani,
                'total_kalori_lauk_nabati' => $total_kalori_lauk_nabati,
                'total_kalori_sayur' => $total_kalori_sayur,
                'total_kalori_buah' => $total_kalori_buah,
                'total_kalori' => $total_kalori,
                'hasil_gizi' => $hasil_gizi,
            ]);

            $results = [
                'hasil_sarapan' => $checkJurnalMakanUser
            ];

            return $this->sendResponse($results, 'Jurnal Makan created or updated successfully.');
        } else {
            // total kalori
            $total_kalori = $input['sarapan_karbohidrat'] + $input['sarapan_lauk_hewani'] + $input['sarapan_lauk_nabati'] + $input['sarapan_sayur'] + $input['sarapan_buah'];

            $insertSarapan = JurnalMakan::create([
                'user_id' => $user->id,
                'usia_kehamilan' => $weekPassed,
                'tanggal' => now(),
                'sarapan_karbohidrat' => $input['sarapan_karbohidrat'],
                'sarapan_lauk_hewani' => $input['sarapan_lauk_hewani'],
                'sarapan_lauk_nabati' => $input['sarapan_lauk_nabati'],
                'sarapan_sayur' => $input['sarapan_sayur'],
                'sarapan_buah' => $input['sarapan_buah'],
                'total_kalori_karbohidrat' => $input['sarapan_karbohidrat'],
                'total_kalori_lauk_hewani' => $input['sarapan_lauk_hewani'],
                'total_kalori_lauk_nabati' => $input['sarapan_lauk_nabati'],
                'total_kalori_sayur' => $input['sarapan_sayur'],
                'total_kalori_buah' => $input['sarapan_buah'],
                'total_kalori' => $total_kalori,
                'hasil_gizi' => $hasil_gizi,
            ]);

            $results = [
                'hasil_sarapan' => $insertSarapan
            ];

            return $this->sendResponse($results, 'Sarapan created successfully.');
        }
    }

    public function insertMakanSiang(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'makan_siang_karbohidrat' => 'required',
            'makan_siang_lauk_hewani' => 'required',
            'makan_siang_lauk_nabati' => 'required',
            'makan_siang_sayur' => 'required',
            'makan_siang_buah' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $user = Auth::user();

        // Cek usia kehamilan berdasar trisemester
        $hariPertamaHaid = $user->hari_pertama_haid;
        $startDate = Carbon::create($hariPertamaHaid);
        // $startDate = Carbon::create(2023, 9, 1);
        $currentDate = Carbon::now();
        $weekPassed = floor($startDate->diffInWeeks($currentDate));

        // Cek apakah ada riwayat mengisi jurnal makan hari ini
        $checkJurnalMakanUser = JurnalMakan::where('user_id', $user->id)->whereDate('tanggal', now())->first();

        // dd($checkJurnalMakanUser);

        $total_kalori = 0;
        $total_kalori_karbohidrat = 0;
        $total_kalori_lauk_hewani = 0;
        $total_kalori_lauk_nabati = 0;
        $total_kalori_sayur = 0;
        $total_kalori_buah = 0;
        $hasil_gizi = "";

        if ($weekPassed <= 12) {
            if ($checkJurnalMakanUser) {
                // dd("sudah pernah isi 5 porsi");
                $total_kalori = $checkJurnalMakanUser->sarapan_karbohidrat +
                    $checkJurnalMakanUser->sarapan_lauk_hewani +
                    $checkJurnalMakanUser->sarapan_lauk_nabati +
                    $checkJurnalMakanUser->sarapan_sayur +
                    $checkJurnalMakanUser->sarapan_buah +
                    $input['makan_siang_karbohidrat'] +
                    $input['makan_siang_lauk_hewani'] +
                    $input['makan_siang_lauk_nabati'] +
                    $input['makan_siang_sayur'] +
                    $input['makan_siang_buah'] +
                    $checkJurnalMakanUser->makan_malam_karbohidrat +
                    $checkJurnalMakanUser->makan_malam_lauk_hewani +
                    $checkJurnalMakanUser->makan_malam_lauk_nabati +
                    $checkJurnalMakanUser->makan_malam_sayur +
                    $checkJurnalMakanUser->makan_malam_buah;

                $total_kalori_karbohidrat = $checkJurnalMakanUser->sarapan_karbohidrat + $input['makan_siang_karbohidrat'] + $checkJurnalMakanUser->makan_malam_karbohidrat;
                $total_kalori_lauk_hewani = $checkJurnalMakanUser->sarapan_lauk_hewani + $input['makan_siang_lauk_hewani'] + $checkJurnalMakanUser->makan_malam_lauk_hewani;
                $total_kalori_lauk_nabati = $checkJurnalMakanUser->sarapan_lauk_nabati + $input['makan_siang_lauk_nabati'] + $checkJurnalMakanUser->makan_malam_lauk_nabati;
                $total_kalori_sayur = $checkJurnalMakanUser->sarapan_sayur + $input['makan_siang_sayur'] + $checkJurnalMakanUser->makan_malam_sayur;
                $total_kalori_buah = $checkJurnalMakanUser->sarapan_buah + $input['makan_siang_buah'] + $checkJurnalMakanUser->makan_malam_buah;

                if ($total_kalori_karbohidrat < 5) {
                    $hasil_gizi = "Gizi Tidak Seimbang";
                } else {
                    $hasil_gizi = "Gizi Seimbang";
                }
            } else {
                // dd("Belum pernah isi 5 porsi");
                if ($input['makan_siang_karbohidrat'] < 5) {
                    $hasil_gizi = "Gizi Tidak Seimbang";
                } else {
                    $hasil_gizi = "Gizi Seimbang";
                }
            }
        } else if ($weekPassed > 12) {
            if ($checkJurnalMakanUser) {
                // dd("sudah pernah isi 6 porsi");
                $total_kalori = $checkJurnalMakanUser->sarapan_karbohidrat +
                    $checkJurnalMakanUser->sarapan_lauk_hewani +
                    $checkJurnalMakanUser->sarapan_lauk_nabati +
                    $checkJurnalMakanUser->sarapan_sayur +
                    $checkJurnalMakanUser->sarapan_buah +
                    $input['makan_siang_karbohidrat'] +
                    $input['makan_siang_lauk_hewani'] +
                    $input['makan_siang_lauk_nabati'] +
                    $input['makan_siang_sayur'] +
                    $input['makan_siang_buah'] +
                    $checkJurnalMakanUser->makan_malam_karbohidrat +
                    $checkJurnalMakanUser->makan_malam_lauk_hewani +
                    $checkJurnalMakanUser->makan_malam_lauk_nabati +
                    $checkJurnalMakanUser->makan_malam_sayur +
                    $checkJurnalMakanUser->makan_malam_buah;

                $total_kalori_karbohidrat = $checkJurnalMakanUser->sarapan_karbohidrat + $input['makan_siang_karbohidrat'] + $checkJurnalMakanUser->makan_malam_karbohidrat;
                $total_kalori_lauk_hewani = $checkJurnalMakanUser->sarapan_lauk_hewani + $input['makan_siang_lauk_hewani'] + $checkJurnalMakanUser->makan_malam_lauk_hewani;
                $total_kalori_lauk_nabati = $checkJurnalMakanUser->sarapan_lauk_nabati + $input['makan_siang_lauk_nabati'] + $checkJurnalMakanUser->makan_malam_lauk_nabati;
                $total_kalori_sayur = $checkJurnalMakanUser->sarapan_sayur + $input['makan_siang_sayur'] + $checkJurnalMakanUser->makan_malam_sayur;
                $total_kalori_buah = $checkJurnalMakanUser->sarapan_buah + $input['makan_siang_buah'] + $checkJurnalMakanUser->makan_malam_buah;

                if ($total_kalori_karbohidrat < 6) {
                    $hasil_gizi = "Gizi Tidak Seimbang";
                } else {
                    $hasil_gizi = "Gizi Seimbang";
                }
            } else {
                // dd("Belum pernah isi 6 porsi");
                if ($input['makan_siang_karbohidrat'] < 6) {
                    $hasil_gizi = "Gizi Tidak Seimbang";
                } else {
                    $hasil_gizi = "Gizi Seimbang";
                }
            }
        }

        if ($checkJurnalMakanUser) {
            // dd("Gacor");
            $checkJurnalMakanUser->update([
                'usia_kehamilan' => $weekPassed,
                'tanggal' => now(),
                'makan_siang_karbohidrat' => $input['makan_siang_karbohidrat'],
                'makan_siang_lauk_hewani' => $input['makan_siang_lauk_hewani'],
                'makan_siang_lauk_nabati' => $input['makan_siang_lauk_nabati'],
                'makan_siang_sayur' => $input['makan_siang_sayur'],
                'makan_siang_buah' => $input['makan_siang_buah'],
                'total_kalori_karbohidrat' => $total_kalori_karbohidrat,
                'total_kalori_lauk_hewani' => $total_kalori_lauk_hewani,
                'total_kalori_lauk_nabati' => $total_kalori_lauk_nabati,
                'total_kalori_sayur' => $total_kalori_sayur,
                'total_kalori_buah' => $total_kalori_buah,
                'total_kalori' => $total_kalori,
                'hasil_gizi' => $hasil_gizi,
            ]);

            $results = [
                'update_jurnal_makan' => $checkJurnalMakanUser
            ];

            return $this->sendResponse($results, 'Jurnal Makan created or updated successfully.');
        } else {
            // total kalori
            $total_kalori = $input['makan_siang_karbohidrat'] + $input['makan_siang_lauk_hewani'] + $input['makan_siang_lauk_nabati'] + $input['makan_siang_sayur'] + $input['makan_siang_buah'];

            $insertMakanSiang = JurnalMakan::create([
                'user_id' => $user->id,
                'usia_kehamilan' => $weekPassed,
                'tanggal' => now(),
                'makan_siang_karbohidrat' => $input['makan_siang_karbohidrat'],
                'makan_siang_lauk_hewani' => $input['makan_siang_lauk_hewani'],
                'makan_siang_lauk_nabati' => $input['makan_siang_lauk_nabati'],
                'makan_siang_sayur' => $input['makan_siang_sayur'],
                'makan_siang_buah' => $input['makan_siang_buah'],
                'total_kalori_karbohidrat' => $input['makan_siang_karbohidrat'],
                'total_kalori_lauk_hewani' => $input['makan_siang_lauk_hewani'],
                'total_kalori_lauk_nabati' => $input['makan_siang_lauk_nabati'],
                'total_kalori_sayur' => $input['makan_siang_sayur'],
                'total_kalori_buah' => $input['makan_siang_buah'],
                'total_kalori' => $total_kalori,
                'hasil_gizi' => $hasil_gizi,
            ]);

            $results = [
                'hasil_makan_siang' => $insertMakanSiang
            ];

            return $this->sendResponse($results, 'Makan Siang created successfully.');
        }
    }

    public function insertMakanMalam(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'makan_malam_karbohidrat' => 'required',
            'makan_malam_lauk_hewani' => 'required',
            'makan_malam_lauk_nabati' => 'required',
            'makan_malam_sayur' => 'required',
            'makan_malam_buah' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $user = Auth::user();

        // Cek usia kehamilan berdasar trisemester
        $hariPertamaHaid = $user->hari_pertama_haid;
        $startDate = Carbon::create($hariPertamaHaid);
        // $startDate = Carbon::create(2023, 9, 1);
        $currentDate = Carbon::now();
        $weekPassed = floor($startDate->diffInWeeks($currentDate));

        // Cek apakah ada riwayat mengisi jurnal makan hari ini
        $checkJurnalMakanUser = JurnalMakan::where('user_id', $user->id)->whereDate('tanggal', now())->first();

        // Cek apakah pernah atau belum mengisi jurnal makan
        $countJurnalMakanUser = JurnalMakan::where('user_id', $user->id)->count();

        $previousJurnalMakanUser = JurnalMakan::where('user_id', $user->id)->whereDate('tanggal', '<', now())->latest()->first();

        // dd($previousJurnalMakanUser);

        $total_kalori = 0;
        $total_kalori_karbohidrat = 0;
        $total_kalori_lauk_hewani = 0;
        $total_kalori_lauk_nabati = 0;
        $total_kalori_sayur = 0;
        $total_kalori_buah = 0;
        $hasil_gizi = "";

        // Cek trisemester
        if ($weekPassed <= 12) {
            if ($checkJurnalMakanUser) {
                // dd("sudah pernah isi 5 porsi");
                $total_kalori = $checkJurnalMakanUser->sarapan_karbohidrat +
                    $checkJurnalMakanUser->sarapan_lauk_hewani +
                    $checkJurnalMakanUser->sarapan_lauk_nabati +
                    $checkJurnalMakanUser->sarapan_sayur +
                    $checkJurnalMakanUser->sarapan_buah +
                    $checkJurnalMakanUser->makan_siang_karbohidrat +
                    $checkJurnalMakanUser->makan_siang_lauk_hewani +
                    $checkJurnalMakanUser->makan_siang_lauk_nabati +
                    $checkJurnalMakanUser->makan_siang_sayur +
                    $checkJurnalMakanUser->makan_siang_buah +
                    $input['makan_malam_karbohidrat'] +
                    $input['makan_malam_lauk_hewani'] +
                    $input['makan_malam_lauk_nabati'] +
                    $input['makan_malam_sayur'] +
                    $input['makan_malam_buah'];

                $total_kalori_karbohidrat = $checkJurnalMakanUser->sarapan_karbohidrat + $checkJurnalMakanUser->makan_siang_karbohidrat + $input['makan_malam_karbohidrat'];
                $total_kalori_lauk_hewani = $checkJurnalMakanUser->sarapan_lauk_hewani + $checkJurnalMakanUser->makan_siang_lauk_hewani + $input['makan_malam_lauk_hewani'];
                $total_kalori_lauk_nabati = $checkJurnalMakanUser->sarapan_lauk_nabati + $checkJurnalMakanUser->makan_siang_lauk_nabati + $input['makan_malam_lauk_nabati'];
                $total_kalori_sayur = $checkJurnalMakanUser->sarapan_sayur + $checkJurnalMakanUser->makan_siang_sayur + $input['makan_malam_sayur'];
                $total_kalori_buah = $checkJurnalMakanUser->sarapan_buah + $checkJurnalMakanUser->makan_siang_buah + $input['makan_malam_buah'];

                if ($total_kalori_karbohidrat < 5) {
                    $hasil_gizi = "Gizi Tidak Seimbang";
                } else {
                    $hasil_gizi = "Gizi Seimbang";
                }
            } else {
                // dd("Belum pernah isi 5 porsi");
                if ($input['makan_malam_karbohidrat'] < 5) {
                    $hasil_gizi = "Gizi Tidak Seimbang";
                } else {
                    $hasil_gizi = "Gizi Seimbang";
                }
            }
        } else if ($weekPassed > 12) {
            if ($checkJurnalMakanUser) {
                // dd("sudah pernah isi 6 porsi");
                $total_kalori = $checkJurnalMakanUser->sarapan_karbohidrat +
                    $checkJurnalMakanUser->sarapan_lauk_hewani +
                    $checkJurnalMakanUser->sarapan_lauk_nabati +
                    $checkJurnalMakanUser->sarapan_sayur +
                    $checkJurnalMakanUser->sarapan_buah +
                    $checkJurnalMakanUser->makan_siang_karbohidrat +
                    $checkJurnalMakanUser->makan_siang_lauk_hewani +
                    $checkJurnalMakanUser->makan_siang_lauk_nabati +
                    $checkJurnalMakanUser->makan_siang_sayur +
                    $checkJurnalMakanUser->makan_siang_buah +
                    $input['makan_malam_karbohidrat'] +
                    $input['makan_malam_lauk_hewani'] +
                    $input['makan_malam_lauk_nabati'] +
                    $input['makan_malam_sayur'] +
                    $input['makan_malam_buah'];

                $total_kalori_karbohidrat = $checkJurnalMakanUser->sarapan_karbohidrat + $checkJurnalMakanUser->makan_siang_karbohidrat + $input['makan_malam_karbohidrat'];
                $total_kalori_lauk_hewani = $checkJurnalMakanUser->sarapan_lauk_hewani + $checkJurnalMakanUser->makan_siang_lauk_hewani + $input['makan_malam_lauk_hewani'];
                $total_kalori_lauk_nabati = $checkJurnalMakanUser->sarapan_lauk_nabati + $checkJurnalMakanUser->makan_siang_lauk_nabati + $input['makan_malam_lauk_nabati'];
                $total_kalori_sayur = $checkJurnalMakanUser->sarapan_sayur + $checkJurnalMakanUser->makan_siang_sayur + $input['makan_malam_sayur'];
                $total_kalori_buah = $checkJurnalMakanUser->sarapan_buah + $checkJurnalMakanUser->makan_siang_buah + $input['makan_malam_buah'];

                if ($total_kalori_karbohidrat < 6) {
                    $hasil_gizi = "Gizi Tidak Seimbang";
                } else {
                    $hasil_gizi = "Gizi Seimbang";
                }
            } else {
                // dd("Belum pernah isi 6 porsi");
                if ($input['makan_malam_karbohidrat'] < 6) {
                    $hasil_gizi = "Gizi Tidak Seimbang";
                } else {
                    $hasil_gizi = "Gizi Seimbang";
                }
            }
        }

        if ($checkJurnalMakanUser) {
            // dd("Gacor");
            $checkJurnalMakanUser->update([
                'usia_kehamilan' => $weekPassed,
                'tanggal' => now(),
                'makan_malam_karbohidrat' => $input['makan_malam_karbohidrat'],
                'makan_malam_lauk_hewani' => $input['makan_malam_lauk_hewani'],
                'makan_malam_lauk_nabati' => $input['makan_malam_lauk_nabati'],
                'makan_malam_sayur' => $input['makan_malam_sayur'],
                'makan_malam_buah' => $input['makan_malam_buah'],
                'total_kalori_karbohidrat' => $total_kalori_karbohidrat,
                'total_kalori_lauk_hewani' => $total_kalori_lauk_hewani,
                'total_kalori_lauk_nabati' => $total_kalori_lauk_nabati,
                'total_kalori_sayur' => $total_kalori_sayur,
                'total_kalori_buah' => $total_kalori_buah,
                'total_kalori' => $total_kalori,
                'hasil_gizi' => $hasil_gizi,
            ]);

            $pesan = "";
            if ($countJurnalMakanUser <= 1) {

                if ($checkJurnalMakanUser->hasil_gizi == "Gizi Seimbang") {
                    // dd("1 Bunda saat ini konsumsi makan Anda sudah memenuhi gizi seimbang, ayo pertahankan konsumsi makan gizi seimbang");
                    $pesan = "Bunda saat ini konsumsi makan Anda sudah memenuhi gizi seimbang, ayo pertahankan konsumsi makan gizi seimbang";
                } else if ($checkJurnalMakanUser->hasil_gizi == "Gizi Tidak Seimbang") {
                    // dd("2 Bunda saat ini konsumsi makan Anda tidak memenuhi gizi seimbang, ayo tingkatkan konsumsi makan gizi seimbang");
                    $pesan = "Bunda saat ini konsumsi makan Anda tidak memenuhi gizi seimbang, ayo tingkatkan konsumsi makan gizi seimbang";
                } else {
                    // dd("Error");
                    $pesan = "Error";
                }
                // dd("Pertama kali isi");
            } else {

                if ($previousJurnalMakanUser->hasil_gizi == "Gizi Seimbang") {
                    if ($checkJurnalMakanUser->hasil_gizi == "Gizi Seimbang") {
                        // dd("3 Bunda saat ini konsumsi makan Anda sudah memenuhi gizi seimbang, ayo pertahankan konsumsi makan gizi seimbang");
                        $pesan = "Bunda saat ini konsumsi makan Anda sudah memenuhi gizi seimbang, ayo pertahankan konsumsi makan gizi seimbang";
                    } else if ($checkJurnalMakanUser->hasil_gizi == "Gizi Tidak Seimbang") {
                        // dd("4 Bunda saat ini konsumsi makan Anda tidak memenuhi gizi seimbang, ayo tingkatkan konsumsi makan gizi seimbang");
                        $pesan = "Bunda saat ini konsumsi makan Anda tidak memenuhi gizi seimbang, ayo tingkatkan konsumsi makan gizi seimbang";
                    }
                } else if ($previousJurnalMakanUser->hasil_gizi == "Gizi Tidak Seimbang") {
                    if ($checkJurnalMakanUser->hasil_gizi == "Gizi Seimbang") {
                        // dd("5 Bunda saat ini konsumsi makan Anda sudah memenuhi gizi seimbang, ayo pertahankan konsumsi makan gizi seimbang");
                        $pesan = "Bunda saat ini konsumsi makan Anda sudah memenuhi gizi seimbang, ayo pertahankan konsumsi makan gizi seimbang";
                    } else if ($checkJurnalMakanUser->hasil_gizi == "Gizi Tidak Seimbang") {
                        // dd("6 Bunda saat ini konsumsi makan Anda masih belum memenuhi gizi seimbang, ayo tingkatkan konsumsi makan gizi seimbang");
                        $pesan = "Bunda saat ini konsumsi makan Anda masih belum memenuhi gizi seimbang, ayo tingkatkan konsumsi makan gizi seimbang";
                    } else {
                        // dd("Error");
                        $pesan = "Error";
                    }
                } else {
                    // dd("Error");
                    $pesan = "Error";
                }

                // dd("Kedua atau lebih");
            }

            $results = [
                'update_jurnal_makan' => $checkJurnalMakanUser,
                'pesan' => $pesan
            ];

            return $this->sendResponse($results, 'Jurnal Makan created or updated successfully.');
        } else {
            // total kalori
            $total_kalori = $input['makan_malam_karbohidrat'] + $input['makan_malam_lauk_hewani'] + $input['makan_malam_lauk_nabati'] + $input['makan_malam_sayur'] + $input['makan_malam_buah'];

            $insertMakanMalam = JurnalMakan::create([
                'user_id' => $user->id,
                'usia_kehamilan' => $weekPassed,
                'tanggal' => now(),
                'makan_malam_karbohidrat' => $input['makan_malam_karbohidrat'],
                'makan_malam_lauk_hewani' => $input['makan_malam_lauk_hewani'],
                'makan_malam_lauk_nabati' => $input['makan_malam_lauk_nabati'],
                'makan_malam_sayur' => $input['makan_malam_sayur'],
                'makan_malam_buah' => $input['makan_malam_buah'],
                'total_kalori_karbohidrat' => $input['makan_malam_karbohidrat'],
                'total_kalori_lauk_hewani' => $input['makan_malam_lauk_hewani'],
                'total_kalori_lauk_nabati' => $input['makan_malam_lauk_nabati'],
                'total_kalori_sayur' => $input['makan_malam_sayur'],
                'total_kalori_buah' => $input['makan_malam_buah'],
                'total_kalori' => $total_kalori,
                'hasil_gizi' => $hasil_gizi,
            ]);

            $pesan = "";

            if ($hasil_gizi == "Gizi Seimbang") {
                // dd("1 Bunda saat ini konsumsi makan Anda sudah memenuhi gizi seimbang, ayo pertahankan konsumsi makan gizi seimbang");
                $pesan = "Bunda saat ini konsumsi makan Anda sudah memenuhi gizi seimbang, ayo pertahankan konsumsi makan gizi seimbang";
            } else if ($hasil_gizi == "Gizi Tidak Seimbang") {
                // dd("2 Bunda saat ini konsumsi makan Anda tidak memenuhi gizi seimbang, ayo tingkatkan konsumsi makan gizi seimbang");
                $pesan = "Bunda saat ini konsumsi makan Anda tidak memenuhi gizi seimbang, ayo tingkatkan konsumsi makan gizi seimbang";
            } else {
                // dd("Error");
                $pesan = "Error";
            }

            $results = [
                'hasil_makan_malam' => $insertMakanMalam,
                'pesan' => $pesan
            ];

            return $this->sendResponse($results, 'Makan Malam created successfully.');
        }
    }
}
