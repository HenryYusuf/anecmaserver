<?php

namespace App\Lib;

class PhoneFormatter
{
    public function formatPhoneNumberTwilio($phoneNumber)
    {
        // Menghapus spasi, strip, atau karakter tidak perlu
        $phoneNumber = preg_replace('/[^0-9+]/', '', $phoneNumber);

        // Cek apakah nomor dimulai dengan "0"
        if (substr($phoneNumber, 0, 1) == '0') {
            // Ganti "0" dengan "+62"
            return '+62' . substr($phoneNumber, 1);
        } elseif (substr($phoneNumber, 0, 3) == '+62') {
            // Jika sudah berawalan "+62", kembalikan nomor apa adanya
            return $phoneNumber;
        }

        // Jika nomor tidak sesuai dengan pola yang diharapkan, tetap kembalikan apa adanya
        return $phoneNumber;
    }

    public function formatPhoneNumberWaApi($phoneNumber)
    {
        // Menghapus spasi, strip, atau karakter tidak perlu
        $phoneNumber = preg_replace('/[^0-9+]/', '', $phoneNumber);

        // Cek apakah nomor dimulai dengan "0"
        if (substr($phoneNumber, 0, 1) == '0') {
            // Ganti "0" dengan "62" dan tambahkan @c.us di akhir
            return '62' . substr($phoneNumber, 1) . '@c.us';
        } elseif (substr($phoneNumber, 0, 3) == '+62') {
            // Jika berawalan "+62", hilangkan "+" dan tambahkan @c.us di akhir
            return '62' . substr($phoneNumber, 3) . '@c.us';
        } elseif (substr($phoneNumber, 0, 2) == '62') {
            // Jika sudah berawalan "62" tanpa "+", tambahkan @c.us di akhir
            return $phoneNumber . '@c.us';
        }

        // Jika nomor tidak sesuai dengan pola yang diharapkan, tetap kembalikan nomor apa adanya
        return $phoneNumber;
    }
}
