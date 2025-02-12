<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    public function getUser()
    {
        $results = User::whereIn('role', ['istri', 'suami'])->get();

        return $this->sendResponse($results, 'User retrieved successfully');
    }

    public function deleteUser($id)
    {
        $user = User::find($id);

        $user->delete();

        return $this->sendResponse($user, 'User deleted successfully');
    }
}
