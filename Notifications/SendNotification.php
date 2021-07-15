<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SlackMessage;

class SendNotification extends Notification
{
    use Queueable;

     protected $slackMessage;

     public function __construct()
     {
         $this->slackMessage = 'defaultMessage';
     }

     public function setMessage($text)
     {
         $this->slackMessage = $text;
     }

     public function via($notifiable)
     {
         return ['slack'];
     }

     public function toMail($notifiable)
     {
         return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
     }

     public function toArray($notifiable)
     {
         return [

         ];
     }

     public function toSlack($notifiable)
     {
         return (new SlackMessage)
             ->content($this->slackMessage);
     }
}