<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Api\BaseController;
use App\Http\Controllers\Controller;
use App\Models\ReminderTtd;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ReminderTtdController extends BaseController
{
    public function getUserReminderTtd()
    {
        $user = Auth::user();

        $reminder = ReminderTtd::where('user_id', $user->id)->first();

        return $this->sendResponse($reminder, 'Reminder TTD retrieved successfully.');
    }

    public function setReminderTtd(Request $request)
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'waktu_reminder_1' => 'date_format:H:i',
            'waktu_reminder_2' => 'date_format:H:i',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $user = Auth::user();

        $reminderCreateOrUpdated = ReminderTtd::updateOrCreate(
            ['user_id' => $user->id],
            [
                'waktu_reminder_1' => $input['waktu_reminder_1'],
                'is_active_reminder_1' => $input['is_active_reminder_1'],
                'waktu_reminder_2' => $input['waktu_reminder_2'],
                'is_active_reminder_2' => $input['is_active_reminder_2'],
            ]
        );

        return $this->sendResponse($reminderCreateOrUpdated, 'Reminder TTD created or updated successfully.');
    }
}
