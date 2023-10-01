<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\User;
use App\Notifications\ExceptionNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testTelegramNotification()
    {
        $exceptionMessage = "This is a test exception message.";
        $exceptionLine = __LINE__;
        $exceptionFile = __FILE__;

        $user = User::find(1); // Replace with your notifiable user or model

        $notification = new ExceptionNotification($exceptionMessage, $exceptionLine, $exceptionFile);

        $user->notify($notification);

        return "Telegram notification sent!";
    }
}
