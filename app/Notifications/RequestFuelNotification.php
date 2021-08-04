<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use App\Models\RequestFuel;

class RequestFuelNotification extends Notification implements ShouldQueue
{
    use Queueable;
    private $requestData = '';
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(RequestVehicle $newRequest)
    {
        $this->requestData =  $newRequest;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database','broadcast'];
    }

    public function toArray($notifiable)
    {
        return [
            'requestData' => $this->requestData,
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }

    public function broadcastType()
    {
        return 'new-fuel-request';
    }
}
