<?php

namespace App\Trait;

use App\Models\fcm_tokens;
use App\Models\User;
use GuzzleHttp\Client;

trait NotificationTrait
{
    /**
     * send notification
     *
     * @param  string  $message
     * @param  instanceof  $user
     * @return mixed
     */
    public function send_event_notification(User $user, string $title, string $message_ar , string $message_en)
    {
        $client = new Client();
        $server_key = env('FIREBASE_SERVER_KEY');
        if ($server_key == null) {
            return;
        }

        $tokens = fcm_tokens::where('user_id', $user->id)->get();
        foreach ($tokens as $token) {
            
            $response = $client->post('https://fcm.googleapis.com/fcm/send', [
                'headers' => [
                    'Authorization' => 'Bearer '.'AAAAs338BbU:APA91bGL2i1OOc0OxBnJT5_-0vjDRIqfNsITDs8CEpdSU8vC_Krf0oWYaK7dlGdv5i8_ZFCIY1Ic2hfsqwGUFy7mrs0RDQSXdLkxaYNZFyFCsR_d4pRarXOqF5yR4uhQSkMg-qx3uqRf',
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'to' => $token->token,
                    'notification' => [
                        'title' => $title,
                        'body' => (app()->getLocale() == 'ar')?$message_ar : $message_en,
                    ],
                ],
            ]);

        }
    }
}
