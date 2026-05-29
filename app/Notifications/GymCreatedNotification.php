<?php

namespace App\Notifications;

use App\Models\Gym;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class GymCreatedNotification extends Notification
{
    use Queueable;

    public function __construct(public Gym $gym) {}

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Gym Created Successfully')
            ->greeting('Hello ' . $notifiable->name)
            ->line('Your gym has been created successfully.')
            ->line('Gym Name: ' . $this->gym->name)
            ->line('You can now start managing your gym.')
            ->action('Go to Dashboard', url('/dashboard'));
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => 'Gym Created',
            'message' => 'Your gym "' . $this->gym->name . '" has been created successfully.',
            'gym_id' => $this->gym->id,
        ];
    }
}