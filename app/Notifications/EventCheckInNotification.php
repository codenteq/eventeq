<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EventCheckInNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(private readonly int $applicationId, private readonly string $eventName)
    {
        //
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
            ->subject('Etkinlik Check-in')
            ->greeting('Merhaba!')
            ->line($this->eventName . ' etkinliğine başvuru yaptınız. Etkinliğe gelmeyi düşünüyorsanız aşağıdaki linke tıklayarak check-in yapmalısınız. Aksi takdirde etkinliğe katılamayacaksınız.')
            ->line('Check-in sonrası giriş kartınızı alabilirsiniz.')
            ->action('Check in yap', route('application.check-in', $this->applicationId));
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
}
