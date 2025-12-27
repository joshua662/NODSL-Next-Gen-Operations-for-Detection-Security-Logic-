<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GateLog;
use App\Models\Notification;
use App\Models\Resident;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class GateController extends Controller
{
    /**
     * Verify plate number and determine if gate should open
     */
    public function verifyPlate(Request $request): JsonResponse
    {
        $request->validate([
            'plate_number' => 'required|string',
            'image_path' => 'nullable|string', // Path to captured image
        ]);

        $plateNumber = strtoupper(trim($request->plate_number));
        $imagePath = $request->image_path;

        // Find resident by plate number
        $resident = Resident::where('plate_number', $plateNumber)->first();

        if ($resident) {
            // Authorized - gate should open
            $status = 'authorized';
            $ownerName = $resident->name;
            $carModel = $resident->car_model;
            $carColor = $resident->car_color;

            // Log the authorized entry
            $gateLog = GateLog::create([
                'resident_id' => $resident->id,
                'plate_number' => $plateNumber,
                'owner_name' => $ownerName,
                'car_model' => $carModel,
                'car_color' => $carColor,
                'status' => $status,
                'image_path' => $imagePath,
                'timestamp' => now(),
            ]);

            // Create notification for resident
            Notification::create([
                'user_id' => $resident->user_id,
                'type' => 'gate_opened',
                'title' => 'Gate Opened',
                'message' => "Gate opened at {$gateLog->timestamp->format('g:i A')}",
                'gate_log_id' => $gateLog->id,
            ]);

            return response()->json([
                'authorized' => true,
                'status' => $status,
                'resident' => [
                    'name' => $ownerName,
                    'plate_number' => $plateNumber,
                    'car_model' => $carModel,
                    'car_color' => $carColor,
                ],
                'gate_log_id' => $gateLog->id,
            ]);
        } else {
            // Unauthorized - gate should remain closed
            $status = 'unauthorized';

            // Log the unauthorized attempt
            $gateLog = GateLog::create([
                'resident_id' => null,
                'plate_number' => $plateNumber,
                'owner_name' => null,
                'car_model' => null,
                'car_color' => null,
                'status' => $status,
                'image_path' => $imagePath,
                'timestamp' => now(),
            ]);

            // Create notification for all admins (if needed)
            // You can add admin notification logic here

            return response()->json([
                'authorized' => false,
                'status' => $status,
                'message' => 'Unauthorized vehicle detected',
                'gate_log_id' => $gateLog->id,
            ], 403);
        }
    }

    /**
     * Log gate event (alternative endpoint for logging)
     */
    public function logEvent(Request $request): JsonResponse
    {
        $request->validate([
            'plate_number' => 'required|string',
            'status' => 'required|in:authorized,unauthorized',
            'image_path' => 'nullable|string',
            'timestamp' => 'nullable|date',
        ]);

        $plateNumber = strtoupper(trim($request->plate_number));
        $resident = Resident::where('plate_number', $plateNumber)->first();

        $gateLog = GateLog::create([
            'resident_id' => $resident?->id,
            'plate_number' => $plateNumber,
            'owner_name' => $resident?->name,
            'car_model' => $resident?->car_model,
            'car_color' => $resident?->car_color,
            'status' => $request->status,
            'image_path' => $request->image_path,
            'timestamp' => $request->timestamp ? new \DateTime($request->timestamp) : now(),
        ]);

        // Create notification if authorized
        if ($request->status === 'authorized' && $resident) {
            Notification::create([
                'user_id' => $resident->user_id,
                'type' => 'gate_opened',
                'title' => 'Gate Opened',
                'message' => "Gate opened at {$gateLog->timestamp->format('g:i A')}",
                'gate_log_id' => $gateLog->id,
            ]);
        }

        return response()->json([
            'success' => true,
            'gate_log_id' => $gateLog->id,
        ]);
    }
}
