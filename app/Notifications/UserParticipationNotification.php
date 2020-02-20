<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserParticipationNotification extends Notification implements ShouldQueue
{

    use Queueable;

//    /**
//     * @var
//     */
//    public $user;
//
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
    public $email;
//
//
//    /**
//     * @var
//     */
//    public $attach;
//
//    /**
//     * @var
//     */
    public $attachPath;

    /**
     * @var
     */
    public $attachName;

    /**
     * @var
     */
    public $attachType;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct() {
//        $this->user = $user;
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
        if(!empty($this->email)){
            $notifiable->email = $this->email;
        }
        if(!empty($this->attachPath)){
            return (new MailMessage)
                ->success()
                ->subject($this->subject)
                ->line($this->content)
                ->attach($this->attachPath, [
                    'as' => $this->attachName,
                    'mime' => $this->attachType,
                ]);
        }
        return (new MailMessage)
            ->success()
            ->subject($this->subject)
            ->line($this->content);
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

    /**
     * @param $attach
     */
    public function attach($attach){
        $this->attach  = $attach;
    }
}
