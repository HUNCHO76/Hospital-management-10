<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Services\NotificationService;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    protected $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /**
     * Display user's notifications
     */
    public function index(Request $request)
    {
        $query = Notification::where('recipient_id', auth()->id());

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('channel')) {
            $query->where('channel', $request->channel);
        }

        $notifications = $query->orderBy('created_at', 'desc')->paginate(20);
        $unreadCount = Notification::where('recipient_id', auth()->id())
                                   ->whereNull('read_at')
                                   ->count();

        return view('notifications.index', compact('notifications', 'unreadCount'));
    }

    /**
     * Mark notification as read
     */
    public function markAsRead(Notification $notification)
    {
        // Check authorization
        if ($notification->recipient_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $notification->update(['read_at' => now()]);

        return back()->with('success', 'Notification marked as read');
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead()
    {
        Notification::where('recipient_id', auth()->id())
                   ->whereNull('read_at')
                   ->update(['read_at' => now()]);

        return back()->with('success', 'All notifications marked as read');
    }

    /**
     * Delete a notification
     */
    public function destroy(Notification $notification)
    {
        // Check authorization
        if ($notification->recipient_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $notification->delete();

        return back()->with('success', 'Notification deleted');
    }

    /**
     * Get pending notifications (API)
     */
    public function getPending()
    {
        $notifications = $this->notificationService->getPendingNotifications(auth()->id(), 10);

        return response()->json([
            'count' => $notifications->count(),
            'notifications' => $notifications,
        ]);
    }
}
