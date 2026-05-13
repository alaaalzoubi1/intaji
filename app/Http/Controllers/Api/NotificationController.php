<?php

namespace App\Http\Controllers\Api;

use App\Models\AppNotification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends ApiController
{
    // GET /api/notifications  (FR-12)
    public function index(Request $request): JsonResponse
    {
        $notifications = AppNotification::where('user_id', $request->user()->id)
            ->orderByDesc('created_at')
            ->paginate(30);

        return $this->success($notifications);
    }

    // POST /api/notifications/{id}/read
    public function markRead(Request $request, AppNotification $notification): JsonResponse
    {
        abort_if($notification->user_id !== $request->user()->id, 403);
        $notification->markAsRead();
        return $this->success(message: 'تم التحديث');
    }

    // POST /api/notifications/read-all
    public function markAllRead(Request $request): JsonResponse
    {
        AppNotification::where('user_id', $request->user()->id)->unread()->update(['is_read' => true]);
        return $this->success(message: 'تم تحديد الكل كمقروء');
    }

    // GET /api/notifications/unread-count
    public function unreadCount(Request $request): JsonResponse
    {
        $count = AppNotification::where('user_id', $request->user()->id)->unread()->count();
        return $this->success(['count' => $count]);
    }
}
