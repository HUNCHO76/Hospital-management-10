<?php

namespace App\Listeners;

use App\Events\AppointmentScheduled;
use App\Services\NotificationService;

class SendAppointmentReminder
{
    public function __construct(protected NotificationService $notificationService)
    {
    }

    public function handle(AppointmentScheduled $event)
    {
        $this->notificationService->sendAppointmentReminder($event->appointment);
    }
}
