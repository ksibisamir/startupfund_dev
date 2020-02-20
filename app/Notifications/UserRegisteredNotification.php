<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;


class UserRegisteredNotification extends Notification implements ShouldQueue
{
    use Queueable;


    /**
     * @var
     */
    public $user;


    /**
     * @var
     */
    public $subject;

    /**
     * @var
     */
    public $content;


    /**
     * @var
     */
    public $forAdmin = false;


    /**
     * @var
     */
    public $email;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user) {
        $this->user = $user;
    }

    /**
     * @param $notifiable
     * @return array
     */
    public function via($notifiable) {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable) {

        if($this->forAdmin){
            $notifiable->email = $this->email;
            return (new MailMessage)
                ->success()
                ->subject($this->subject)
                ->line($this->content);
        }else{
            return (new MailMessage)
                ->success()
                ->subject($this->subject)
                ->line($this->content)
                ->action(trans('app.go_to_site'), url('/'));
        }
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
            //
        ];
    }
}
