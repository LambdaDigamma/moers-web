<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ClosedHelpRequestNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Eine Hilfesuche wurde geschlossen')
                    ->greeting('Hallo!')
                    ->line('Eine der Hilfesuchen, die du bearbeiten wolltest / bearbeitet hast, wurde geschlossen.')
                    ->line('Vielen Dank für deine Hilfsbereitschaft!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'title' => 'Hilfesuche geschlossen',
            'description' => 'Eine der Hilfesuchen, die du bearbeiten wolltest / bearbeitet hast, wurde geschlossen. Vielen Dank für deine Hilfsbereitschaft!'
        ];
    }
}
