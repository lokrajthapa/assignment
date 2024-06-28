<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Application;

class JobApplicationSubmitted extends Notification
{
    use Queueable;
    protected $jobApplication;

    /**
     * Create a new notification instance.
     */
    public function __construct(Application $jobApplication)
    {
        $this->jobApplication= $jobApplication;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail','database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                     ->subject('Job Application Appeared')
                     ->line('The Application titled "' . $this->jobApplication->title . '" has been updated.')
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
            'title' => $this->jobApplication->title,
            'description' => $this->jobApplication->description,
            'resume' => $this->jobApplication->resume,
            'cover_letter' => $this->jobApplication->cover_letter,


        ];
    }
}
