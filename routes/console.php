<?php

use App\Lib\PhoneFormatter;
use App\Lib\RandomImage;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schedule;
use WaAPI\WaAPI\WaAPI;

// use Twilio\Rest\Client;

// Artisan::command('inspire', function () {
//     $this->comment(Inspiring::quote());
// })->purpose('Display an inspiring quote')->hourly();


// Schedule::call(function () {
//     $date = Carbon::now();
//     $date->tz('Asia/Jakarta');

//     $sid    = getenv("TWILIO_AUTH_SID");
//     $token  = getenv("TWILIO_AUTH_TOKEN");
//     $wa_from = getenv("TWILIO_WHATSAPP_FROM");
//     $twilio = new Client($sid, $token);

//     $getUserReminder = User::where('role', 'istri')->with('reminder_ttd')->get();

//     foreach ($getUserReminder as $user) {
//         $userNoHp = $user->no_hp;
//         $userIsActiveReminder1 = $user->reminder_ttd->is_active_reminder_1;
//         $userWaktuReminder1 = $user->reminder_ttd->waktu_reminder_1;
//         $userIsActiveReminder2 = $user->reminder_ttd->is_active_reminder_2;
//         $userWaktuReminder2 = $user->reminder_ttd->waktu_reminder_2;

//         $phoneFormatter = new PhoneFormatter();
//         $formattedNoHp = $phoneFormatter->formatPhoneNumberTwilio($userNoHp);

//         $formattedWaktuReminder1 = Carbon::createFromFormat('H:i:s', $userWaktuReminder1)->format('H:i');
//         $formattedWaktuReminder2 = Carbon::createFromFormat('H:i:s', $userWaktuReminder2)->format('H:i');

//         if ($userIsActiveReminder1 == 1 || $userIsActiveReminder2 == 1) {
//             if ($formattedWaktuReminder1 == $date->format('H:i') || $formattedWaktuReminder2 == $date->format('H:i')) {
//                 $twilio->messages->create(
//                     "whatsapp:$formattedNoHp",
//                     [
//                         "from" => "whatsapp:$wa_from",
//                         "mediaUrl" => [
//                             'https://images.unsplash.com/photo-1545093149-618ce3bcf49d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=668&q=80'
//                         ]
//                     ]
//                 );
//             }
//         }
//     }
// })->everyMinute();


// Schedule::call(function () {
//     $date = Carbon::now();
//     $date->tz('Asia/Jakarta');

//     $waAPI = new WaAPI();

//     $getRandomImage = new RandomImage();
//     $image = $getRandomImage->getImage();

//     $getUserReminder = User::where('role', 'istri')->with('reminder_ttd')->get();

//     foreach ($getUserReminder as $user) {
//         $userNoHp = $user->no_hp;
//         $userIsActiveReminder1 = $user->reminder_ttd->is_active_reminder_1;
//         $userWaktuReminder1 = $user->reminder_ttd->waktu_reminder_1;
//         $userIsActiveReminder2 = $user->reminder_ttd->is_active_reminder_2;
//         $userWaktuReminder2 = $user->reminder_ttd->waktu_reminder_2;

//         $phoneFormatter = new PhoneFormatter();
//         $formattedNoHp = $phoneFormatter->formatPhoneNumberWaApi($userNoHp);

//         $formattedWaktuReminder1 = Carbon::createFromFormat('H:i:s', $userWaktuReminder1)->format('H:i');
//         $formattedWaktuReminder2 = Carbon::createFromFormat('H:i:s', $userWaktuReminder2)->format('H:i');

//         if ($userIsActiveReminder1 == 1) {
//             if ($formattedWaktuReminder1 == $date->format('H:i')) {
//                 $waAPI->sendMediaFromUrl($formattedNoHp, $image, "Notifikasi Anecma \nJangan Lupa Minum Tablet Tambah Darah 😁", "Reminder TTD");
//             }
//         }

//         if ($userIsActiveReminder2 == 1) {
//             if ($formattedWaktuReminder2 == $date->format('H:i')) {
//                 $waAPI->sendMediaFromUrl($formattedNoHp, $image, "Notifikasi Anecma \nJangan Lupa Minum Tablet Tambah Darah 😁", "Reminder TTD");
//             }
//         }
//     }
// })->everyMinute();

Schedule::command('queue:work --stop-when-empty')->everyMinute()->withoutOverlapping();

Schedule::call(function () {
    // Mengatur timezone ke Asia/Jakarta
    $date = Carbon::now('Asia/Jakarta');

    // Inisialisasi WaAPI dan RandomImage
    $waAPI = new WaAPI();
    $getRandomImage = new RandomImage();
    $image = $getRandomImage->getImage();

    // Mendapatkan pengguna yang memiliki role 'istri' dan pengingat aktif
    $getUserReminder = User::where('role', 'istri')
        ->whereHas('reminder_ttd', function ($query) {
            $query->where('is_active_reminder_1', 1)
                ->orWhere('is_active_reminder_2', 1);
        })
        ->with('reminder_ttd')
        ->get();

    foreach ($getUserReminder as $user) {
        $userNoHp = $user->no_hp;
        $reminder = $user->reminder_ttd;

        $userIsActiveReminder1 = $reminder->is_active_reminder_1;
        $userWaktuReminder1 = Carbon::createFromFormat('H:i:s', $reminder->waktu_reminder_1)->format('H:i');

        $userIsActiveReminder2 = $reminder->is_active_reminder_2;
        $userWaktuReminder2 = Carbon::createFromFormat('H:i:s', $reminder->waktu_reminder_2)->format('H:i');

        $phoneFormatter = new PhoneFormatter();
        $formattedNoHp = $phoneFormatter->formatPhoneNumberWaApi($userNoHp);

        // Kirim pengingat berdasarkan waktu pengingat yang aktif
        if (($userIsActiveReminder1 && $userWaktuReminder1 == $date->format('H:i')) ||
            ($userIsActiveReminder2 && $userWaktuReminder2 == $date->format('H:i'))
        ) {

            // Mengirim pesan dengan gambar melalui API WhatsApp
            dispatch(function () use ($waAPI, $formattedNoHp, $image) {
                $waAPI->sendMediaFromUrl($formattedNoHp, $image, 'Notifikasi ANECMA \n\n*"Bunda sehat, si kecil kuat! Yuk, minum tablet tambah darah sekarang! 😊"* \n\nKalau sudah minum tabletnya, jangan lupa isi di sini ya, Bun! \n\nhttps://www.anecma.id/istri/dashboard/konsumsi-ttd', "Reminder TTD");
            });
        }
    }
})->everyMinute();
