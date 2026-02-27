<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class TadikaOwnerInAppMessage extends Notification
{
    use Queueable;

    /**
     * @var array<string, string>
     */
    protected array $payload;

    /**
     * @param  array<string, string>  $payload
     */
    public function __construct(array $payload)
    {
        $this->payload = $payload;
    }

    /**
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * @return array<string, string>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'subject' => $this->payload['subject'] ?? '',
            'message' => $this->payload['message'] ?? '',
            'sender_name' => $this->payload['sender_name'] ?? '',
        ];
    }
}
