<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Resident;
use App\Models\UpdateRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResidentController extends Controller
{
    /**
     * Get resident profile
     */
    public function getProfile(): JsonResponse
    {
        $user = Auth::user();
        $resident = $user->resident;

        if (! $resident) {
            return response()->json(['error' => 'Resident profile not found'], 404);
        }

        return response()->json([
            'profile' => [
                'name' => $resident->name,
                'age' => $resident->age,
                'address' => $resident->address,
                'plate_number' => $resident->plate_number,
                'car_model' => $resident->car_model,
                'car_color' => $resident->car_color,
                'contact_number' => $resident->contact_number,
            ],
        ]);
    }

    /**
     * Update resident profile (creates update request)
     */
    public function updateProfile(Request $request): JsonResponse
    {
        $user = Auth::user();
        $resident = $user->resident;

        if (! $resident) {
            return response()->json(['error' => 'Resident profile not found'], 404);
        }

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'age' => 'sometimes|integer|min:1|max:150',
            'address' => 'sometimes|string',
            'plate_number' => 'sometimes|string|max:20|unique:residents,plate_number,' . $resident->id,
            'car_model' => 'sometimes|nullable|string|max:255',
            'car_color' => 'sometimes|nullable|string|max:100',
            'contact_number' => 'sometimes|string|max:20',
        ]);

        // Collect requested changes
        $requestedChanges = $request->only([
            'name', 'age', 'address', 'plate_number', 'car_model', 'car_color', 'contact_number'
        ]);

        // Remove null values
        $requestedChanges = array_filter($requestedChanges, fn($value) => !is_null($value));

        if (empty($requestedChanges)) {
            return response()->json(['error' => 'No changes provided'], 400);
        }

        // Create update request
        $updateRequest = UpdateRequest::create([
            'resident_id' => $resident->id,
            'status' => 'pending',
            'requested_changes' => $requestedChanges,
        ]);

        // Create notification for admin (you might want to notify admins)
        // For now, we'll just return success

        return response()->json([
            'success' => true,
            'message' => 'Update request submitted successfully. Waiting for admin approval.',
            'update_request_id' => $updateRequest->id,
        ]);
    }

    /**
     * Get resident's gate logs
     */
    public function getLogs(Request $request): JsonResponse
    {
        $user = Auth::user();
        $resident = $user->resident;

        if (! $resident) {
            return response()->json(['error' => 'Resident profile not found'], 404);
        }

        $limit = $request->input('limit', 50);
        $offset = $request->input('offset', 0);

        $logs = $resident->gateLogs()
            ->orderBy('timestamp', 'desc')
            ->skip($offset)
            ->take($limit)
            ->get()
            ->map(function ($log) {
                return [
                    'id' => $log->id,
                    'plate_number' => $log->plate_number,
                    'status' => $log->status,
                    'timestamp' => $log->timestamp->toIso8601String(),
                    'image_path' => $log->image_path,
                ];
            });

        return response()->json([
            'logs' => $logs,
            'total' => $resident->gateLogs()->count(),
        ]);
    }

    /**
     * Get resident's notifications
     */
    public function getNotifications(Request $request): JsonResponse
    {
        $user = Auth::user();

        $limit = $request->input('limit', 50);
        $unreadOnly = $request->boolean('unread_only', false);

        $query = $user->notifications()->orderBy('created_at', 'desc');

        if ($unreadOnly) {
            $query->where('is_read', false);
        }

        $notifications = $query->take($limit)->get()->map(function ($notification) {
            return [
                'id' => $notification->id,
                'type' => $notification->type,
                'title' => $notification->title,
                'message' => $notification->message,
                'is_read' => $notification->is_read,
                'created_at' => $notification->created_at->toIso8601String(),
            ];
        });

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $user->notifications()->where('is_read', false)->count(),
        ]);
    }

    /**
     * Mark notification as read
     */
    public function markAsRead($notificationId): JsonResponse
    {
        $user = Auth::user();
        $notification = $user->notifications()->find($notificationId);

        if (! $notification) {
            return response()->json(['error' => 'Notification not found'], 404);
        }

        $notification->update(['is_read' => true]);

        return response()->json(['success' => true]);
    }

    /**
     * Submit update request
     */
    public function submitUpdateRequest(Request $request): JsonResponse
    {
        return $this->updateProfile($request); // Reuse updateProfile logic
    }

    /**
     * Get update requests for resident
     */
    public function getUpdateRequests(): JsonResponse
    {
        $user = Auth::user();
        $resident = $user->resident;

        if (! $resident) {
            return response()->json(['error' => 'Resident profile not found'], 404);
        }

        $requests = $resident->updateRequests()
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($updateRequest) {
                return [
                    'id' => $updateRequest->id,
                    'status' => $updateRequest->status,
                    'requested_changes' => $updateRequest->requested_changes,
                    'reason' => $updateRequest->reason,
                    'created_at' => $updateRequest->created_at->toIso8601String(),
                    'reviewed_at' => $updateRequest->reviewed_at?->toIso8601String(),
                ];
            });

        return response()->json(['update_requests' => $requests]);
    }
}
