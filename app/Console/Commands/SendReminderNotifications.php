<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Notifications\ReminderEmailNotification;
use App\Calendar;
use App\Task;
use Illuminate\Support\Facades\Notification;
use Carbon\Carbon;

class SendReminderNotifications extends Command
{
    protected $signature = 'notifications:send-reminders';

    protected $description = 'Send reminder notifications for tasks and events due in 2 days';

    public function handle()
    {
        $dueDate = now()->addDays(2)->toDateString();

        // Find tasks due in 2 days
        $tasks = Task::whereDate('end_date', $dueDate)->get();
        foreach ($tasks as $task) {
            Notification::route('mail', 'user@example.com')->notify(new ReminderEmailNotification($task));
        }

        // Find calendar events due in 2 days
        $events = Calendar::whereDate('end_date', $dueDate)->get();
        foreach ($events as $event) {
            Notification::route('mail', 'user@example.com')->notify(new ReminderEmailNotification($event));
        }

        $this->info('Reminder notifications sent successfully!');
    }
}
