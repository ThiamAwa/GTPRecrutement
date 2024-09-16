<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewMissionSubmitted extends Notification
{
    use Queueable;
    public $mission;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        return ['database'];
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }

    public function toDatabase($notifiable)
    {
        return [
            'mission_id' => $this->mission->id,
            'titre' => $this->mission->titre,
            'description' => $this->mission->description,
            'date_debut' => $this->mission->date_debut,
            'date_fin' => $this->mission->date_fin,
            'client_id' => $this->mission->client_id,
        ];
    }
}
