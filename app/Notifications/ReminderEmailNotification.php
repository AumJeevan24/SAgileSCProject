<?php
namespace App\Notifications;

use App\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ReminderEmailNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Reminder: Task Due Soon')
                    ->line('Your task "'.$this->task->title.'" is due soon. Please take necessary actions.')
                    ->action('View Task', url('/tasks/'.$this->task->id));
    }
}
