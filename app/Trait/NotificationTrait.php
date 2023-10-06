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
                    'Authorization' => 'Bearer '.$server_key,
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
