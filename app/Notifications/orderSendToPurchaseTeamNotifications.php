<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class orderSendToPurchaseTeamNotifications extends Notification
{
    use Queueable;

    public $requirement;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($requirement)
    {
        $this->requirement = $requirement;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase()
    {
        return [
            'requirements' => $this->requirement
        ];
    }
}
