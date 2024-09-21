<?php

use App\Lib\PhoneFormatter;
use App\Lib\RandomImage;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;
use Twilio\Rest\Client;
use WaAPI\WaAPI\WaAPI;

Route::get('/', function () {
    // $check = User::where('role', 'istri')->with('reminder_ttd')->get();

    // $date = Carbon::now();
    // $date->tz('Asia/Jakarta');
    // echo $date->format('H:i');

    // $getUserReminder = User::where('role', 'istri')->with('reminder_ttd')->get();

    // foreach ($getUserReminder as $user) {
    //     $userNoHp = $user->no_hp;
    //     $userIsActiveReminder1 = $user->reminder_ttd->is_active_reminder_1;
    //     $userWaktuReminder1 = $user->reminder_ttd->waktu_reminder_1;
    //     $userIsActiveReminder2 = $user->reminder_ttd->is_active_reminder_2;
    //     $userWaktuReminder2 = $user->reminder_ttd->waktu_reminder_2;

    //     $formattedWaktuReminder1 = Carbon::createFromFormat('H:i:s', $userWaktuReminder1)->format('H:i');
    //     $formattedWaktuReminder2 = Carbon::createFromFormat('H:i:s', $userWaktuReminder2)->format('H:i');


    // dd($formattedWaktuReminder1 == $date->format('H:i'));

    // if ($userIsActiveReminder1 == 1 || $userIsActiveReminder2 == 1) {
    //     dd("send notif");
    //     if (($userIsActiveReminder1 == 1 && $formattedWaktuReminder1 == $date->format('H:i')) ||
    //         ($userIsActiveReminder2 == 1 && $formattedWaktuReminder2 == $date->format('H:i'))
    //     ) {
    //         dd("send notif");
    //     } else {
    //         dd("dont send notif");
    //     }
    // } else {
    //     dd("dont send notif");
    // }

    //     if ($userIsActiveReminder1 == 1) {
    //         if ($formattedWaktuReminder1 == $date->format('H:i')) {
    //             dd("send notif 1");
    //         }
    //     }

    //     if ($userIsActiveReminder2 == 1) {
    //         if ($formattedWaktuReminder2 == $date->format('H:i')) {
    //             dd("send notif 2");
    //         }
    //     }
    // }

    // $sid    = getenv("TWILIO_AUTH_SID");
    // $token  = getenv("TWILIO_AUTH_TOKEN");
    // $wa_from = getenv("TWILIO_WHATSAPP_FROM");
    // $twilio = new Client($sid, $token);

    // return $twilio->messages->create(
    //     "whatsapp:+6282244859815",
    //     [
    //         "from" => "whatsapp:$wa_from",
    //         "body" => "Tes",
    //         "mediaUrl" => [
    //             'https://images.unsplash.com/photo-1545093149-618ce3bcf49d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=668&q=80'
    //         ]
    //     ]
    // );

    // $waAPI = new WaAPI();
    // $waAPI->sendMediaFromUrl('6282244859815@c.us', 'https://images.unsplash.com/photo-1545093149-618ce3bcf49d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=668&q=80', "", "Dampak");

    // $phoneFormatter = new PhoneFormatter();
    // $formattedNoHp = $phoneFormatter->formatPhoneNumberWaApi("082244859815");

    // $getRandomImage = new RandomImage();
    // $image = $getRandomImage->getImage();
    // dd($image);

    // $date = Carbon::now('Asia/Jakarta');
    // $getUserReminder = User::where('role', 'istri')
    //     ->whereHas('reminder_ttd', function ($query) {
    //         $query->where('is_active_reminder_1', 1)
    //             ->orWhere('is_active_reminder_2', 1);
    //     })
    //     ->with('reminder_ttd')
    //     ->get();

    // dd($getUserReminder);

    // foreach ($getUserReminder as $user) {

    // }


    // return $user;
});
