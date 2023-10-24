<?php

namespace App\Trait;

use App\Models\fcm_tokens;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

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
    
            $tokens = fcm_tokens::where('user_id', $user->id)->get();
            foreach($tokens as $token){
                $reqData['to'] = $token->token;
                $reqData['data']['title'] = $title;
                $reqData['data']['body'] = (app()->getLocale() == 'ar')?$message_ar : $message_en;
                $reqData['data']['click_action'] = 'FLUTTER_NOTIFICATION_CLICK';
                $reqData['priority'] = 'high';
                $reqData['notification']['body'] = (app()->getLocale() == 'ar')?$message_ar : $message_en;
                $reqData['notification']['title'] = $title;
                $reqData['notification']['content_available'] = true;
                $reqData['notification']['badge'] = 0;
                $reqData['notification']['priority'] = 'high';
        
        
                Http::withHeaders([
                    'Content-Type' => 'application/json',
                    'Authorization' => 'key=' . 'AAAAs338BbU:APA91bEEU5JrJVPav4A57RqjfwYVmR3o0GuleaAU2HXIRf5HUYV2LYCY_5Jf9qWrNHz7xvJKQcJxJoqms1Px-fiw_gR84ZPzSTWaSGxATKpScNkytkWPKZZabctnKRykKd7fqq8OtPxK',
                ])->post('https://fcm.googleapis.com/fcm/send', $reqData);
            }
    }
}
