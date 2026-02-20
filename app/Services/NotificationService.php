<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Exception;

class NotificationService
{
    /**
     * Send appointment reminder via Email and SMS
     */
    public function sendAppointmentReminder($appointment)
    {
        $patient = $appointment->patient;
        $user = $patient->user;

        $title = 'Appointment Reminder';
        $message = "You have an appointment with {$appointment->doctor->user->FirstName} on {$appointment->appointment_date->format('M d, Y H:i')}";

        // Send via Email
        if (!empty($user->email)) {
            $this->createNotification(
                $user->id,
                Notification::TYPE_APPOINTMENT,
                Notification::CHANNEL_EMAIL,
                $title,
                $message,
                ['appointment_id' => $appointment->id]
            );
        }

        // Send via SMS if phone available
        if (!empty($patient->phone)) {
            $this->createNotification(
                $user->id,
                Notification::TYPE_APPOINTMENT,
                Notification::CHANNEL_SMS,
                $title,
                $message,
                ['appointment_id' => $appointment->id, 'phone' => $patient->phone]
            );
        }

        return true;
    }

    /**
     * Send lab result notification
     */
    public function sendLabResultNotification($labResult)
    {
        $patient = $labResult->patient;
        $user = $patient->user;

        $title = 'Lab Results Available';
        $message = 'Your lab test results are now available. Please contact your doctor to review them.';

        $this->createNotification(
            $user->id,
            Notification::TYPE_LAB_RESULT,
            Notification::CHANNEL_EMAIL,
            $title,
            $message,
            ['lab_result_id' => $labResult->id]
        );

        if (!empty($patient->phone)) {
            $this->createNotification(
                $user->id,
                Notification::TYPE_LAB_RESULT,
                Notification::CHANNEL_SMS,
                $title,
                'Your lab results are ready',
                ['lab_result_id' => $labResult->id, 'phone' => $patient->phone]
            );
        }

        return true;
    }

    /**
     * Send prescription notification
     */
    public function sendPrescriptionNotification($prescription)
    {
        $patient = $prescription->patient;
        $user = $patient->user;

        $title = 'New Prescription';
        $message = "You have a new prescription from {$prescription->doctor->user->FirstName}. Please collect it from the pharmacy.";

        $this->createNotification(
            $user->id,
            Notification::TYPE_PRESCRIPTION,
            Notification::CHANNEL_EMAIL,
            $title,
            $message,
            ['prescription_id' => $prescription->id]
        );

        if (!empty($patient->phone)) {
            $this->createNotification(
                $user->id,
                Notification::TYPE_PRESCRIPTION,
                Notification::CHANNEL_SMS,
                $title,
                'You have a new prescription ready for pickup',
                ['prescription_id' => $prescription->id, 'phone' => $patient->phone]
            );
        }

        return true;
    }

    /**
     * Send bill notification
     */
    public function sendBillNotification($bill)
    {
        $patient = $bill->patient;
        $user = $patient->user;

        $title = 'Invoice Generated';
        $message = "An invoice of {$bill->amount} has been generated for your recent visit.";

        $this->createNotification(
            $user->id,
            Notification::TYPE_BILL,
            Notification::CHANNEL_EMAIL,
            $title,
            $message,
            ['bill_id' => $bill->id, 'amount' => $bill->amount]
        );

        return true;
    }

    /**
     * Send admission notification
     */
    public function sendAdmissionNotification($admission)
    {
        $patient = $admission->patient;
        $user = $patient->user;

        $title = 'Admission Confirmation';
        $message = "Your admission has been confirmed. Room: {$admission->room->room_number}. Doctor: {$admission->doctor->user->FirstName}";

        $this->createNotification(
            $user->id,
            Notification::TYPE_ADMISSION,
            Notification::CHANNEL_EMAIL,
            $title,
            $message,
            ['admission_id' => $admission->id, 'room' => $admission->room->room_number]
        );

        if (!empty($patient->phone)) {
            $this->createNotification(
                $user->id,
                Notification::TYPE_ADMISSION,
                Notification::CHANNEL_SMS,
                $title,
                "You have been admitted. Room: {$admission->room->room_number}",
                ['admission_id' => $admission->id, 'phone' => $patient->phone]
            );
        }

        return true;
    }

    /**
     * Create a notification record
     */
    public function createNotification($recipientId, $type, $channel, $title, $message, $data = [])
    {
        return Notification::create([
            'recipient_id' => $recipientId,
            'type' => $type,
            'channel' => $channel,
            'title' => $title,
            'message' => $message,
            'data' => $data,
            'status' => Notification::STATUS_PENDING,
        ]);
    }

    /**
     * Send a notification via its channel
     */
    public function sendNotification(Notification $notification)
    {
        try {
            if ($notification->channel === Notification::CHANNEL_EMAIL) {
                $this->sendEmail($notification);
            } elseif ($notification->channel === Notification::CHANNEL_SMS) {
                $this->sendSMS($notification);
            } elseif ($notification->channel === Notification::CHANNEL_PUSH) {
                $this->sendPush($notification);
            }

            $notification->markAsSent();
            return true;
        } catch (Exception $e) {
            $notification->markAsFailed($e->getMessage());
            return false;
        }
    }

    /**
     * Send notification via email
     */
    private function sendEmail(Notification $notification)
    {
        $user = $notification->recipient;

        // Build email body
        $emailBody = view('emails.notification', [
            'title' => $notification->title,
            'message' => $notification->message,
        ])->render();

        // Send email using configured mail driver
        Mail::to($user->email)->send(new \App\Mail\NotificationMail(
            $notification->title,
            $notification->message,
            $notification->data
        ));
    }

    /**
     * Send notification via SMS
     */
    private function sendSMS(Notification $notification)
    {
        $phone = $notification->data['phone'] ?? null;

        if (!$phone) {
            throw new Exception('Phone number not provided');
        }

        // TODO: Integrate with SMS provider (Twilio, Africa's Talking, etc.)
        // Example with Africa's Talking:
        /*
        $client = new AfricasTalkingClient(
            config('services.africas_talking.api_key'),
            config('services.africas_talking.username')
        );

        $sms = $client->sms();
        $sms->send([
            'phone' => $phone,
            'message' => $notification->message,
        ]);
        */

        // For now, just log it
        \Log::info("SMS would be sent to {$phone}: {$notification->message}");
    }

    /**
     * Send push notification
     */
    private function sendPush(Notification $notification)
    {
        // TODO: Implement push notification logic
        // Can use Firebase Cloud Messaging, OneSignal, etc.
        
        \Log::info("Push notification would be sent: {$notification->title}");
    }

    /**
     * Get pending notifications for a user
     */
    public function getPendingNotifications($userId, $limit = 10)
    {
        return Notification::where('recipient_id', $userId)
                           ->where('status', Notification::STATUS_PENDING)
                           ->orderBy('created_at', 'desc')
                           ->limit($limit)
                           ->get();
    }

    /**
     * Send all pending notifications (for queue job)
     */
    public function sendPendingNotifications($limit = 100)
    {
        $notifications = Notification::where('status', Notification::STATUS_PENDING)
                                     ->orderBy('created_at', 'asc')
                                     ->limit($limit)
                                     ->get();

        foreach ($notifications as $notification) {
            $this->sendNotification($notification);
        }

        return count($notifications);
    }

    /**
     * Mark all notifications as read for user
     */
    public function markAllAsRead($userId)
    {
        return Notification::where('recipient_id', $userId)
                           ->whereNull('read_at')
                           ->update(['read_at' => now()]);
    }
}
