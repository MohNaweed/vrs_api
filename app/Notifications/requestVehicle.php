<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class requestVehicle extends Notification implements ShouldQueue
{
    use Queueable;
    private $requestData;

    public function __construct($requestData)
    {
        $this->requestData = $requestData;
    }

    public function via($notifiable)
    {
        return ['database','broadcast'];
    }



    public function toArray($notifiable)
    {
        return [
            'requestData' => $this->requestData,
            'testData' => 'something'
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }

    public function broadcastType()
    {
        return 'new-comment';
    }
}
