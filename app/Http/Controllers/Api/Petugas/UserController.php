<?php

namespace App\Http\Controllers\Api\Petugas;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends BaseController
{
    public function getUser()
    {
        $user = Auth::user()->load('puskesmas');

        $alamat = $user->puskesmas->first()->alamat;

        $results = User::whereIn('role', ['istri', 'suami'])->where('wilayah_binaan', $alamat)->get();

        return $this->sendResponse($results, 'User retrieved successfully');
    }

    public function deleteUser($id)
    {
        $user = User::find($id);

        $user->delete();

        return $this->sendResponse($user, 'User deleted successfully');
    }
}
