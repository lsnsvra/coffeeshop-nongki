<?php

namespace App\Listeners;

use App\Mail\TwoFactorCodeMail;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Mail;
use Twilio\Rest\Client;

class SendTwoFactorCode
{
    public function handle(Login $event): void
    {
        /** @var \App\Models\User $user */
        $user = $event->user;
        $code = rand(100000, 999999);

        // 1. Update Database
        $user->update([
            'two_factor_code' => $code,
            'two_factor_expires_at' => now()->addMinutes(10),
        ]);

        // 2. Kirim Via Email
      //  Mail::to($user->email)->send(new TwoFactorCodeMail($code)); 

        // 3. Kirim Via WhatsApp (Twilio)
        try {
            $sid = env('TWILIO_SID');
            $token = env('TWILIO_AUTH_TOKEN');
            $from = env('TWILIO_WHATSAPP_NUMBER');
            
            // Pastikan nomor HP user diawali dengan kode negara (misal: +62)
            $to = "whatsapp:" . $user->phone_number; 

            $twilio = new Client($sid, $token);
            $twilio->messages->create($to, [
                "from" => "whatsapp:" . $from,
                "body" => "☕ Coffeeshop Nongki: Kode keamanan Anda adalah $code. Jangan berikan kode ini kepada siapapun."
            ]);
        } catch (\Exception $e) {
            // Jika WA gagal, aplikasi tidak akan crash karena ada try-catch
            report($e);
        }
    }
}