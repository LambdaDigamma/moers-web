<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CompletedHelpRequestNotification extends Notification
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
            ->line('Eine der Hilfesuchen, die du bearbeitet bearbeitet hast, wurde geschlossen.')
            ->line('Aus Gründen des Datenschutzes, wird diese hier nicht noch einmal angezeigt.')
            ->line('Vielen Dank für deine Hilfe!');
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
            'title' => 'Hilfesuche erledigt',
            'description' => 'Eine der Hilfesuchen, die du bearbeitet hast, wurde geschlossen. Vielen Dank für deine Hilfe!'
        ];
    }
}
