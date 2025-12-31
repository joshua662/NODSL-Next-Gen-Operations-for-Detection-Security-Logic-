<?php

namespace App\Http\Controllers\Resident;

use App\Http\Controllers\Controller;
use App\Models\UpdateRequest;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Update resident profile (creates update request)
     */
    public function update(Request $request)
    {
        $user = $request->user();
        $resident = $user->resident;

        if (!$resident) {
            return redirect()->back()->with('error', 'Resident profile not found');
        }

        // Validate incoming data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'age' => 'sometimes|nullable|integer|min:1|max:150',
            'address' => 'sometimes|nullable|string',
            'plate_number' => 'required|string|max:20',
            'car_model' => 'sometimes|nullable|string|max:255',
            'car_color' => 'sometimes|nullable|string|max:100',
            'contact_number' => 'sometimes|nullable|string|max:20',
        ]);

        // Collect the changed fields
        $requestedChanges = [];
        
        if ($validated['name'] !== $resident->name) {
            $requestedChanges['name'] = $validated['name'];
        }
        
        if (isset($validated['age']) && $validated['age'] !== $resident->age) {
            $requestedChanges['age'] = $validated['age'];
        }
        
        if (isset($validated['address']) && $validated['address'] !== $resident->address) {
            $requestedChanges['address'] = $validated['address'];
        }
        
        if ($validated['plate_number'] !== $resident->plate_number) {
            $requestedChanges['plate_number'] = $validated['plate_number'];
        }
        
        if (isset($validated['car_model']) && $validated['car_model'] !== $resident->car_model) {
            $requestedChanges['car_model'] = $validated['car_model'];
        }
        
        if (isset($validated['car_color']) && $validated['car_color'] !== $resident->car_color) {
            $requestedChanges['car_color'] = $validated['car_color'];
        }
        
        if (isset($validated['contact_number']) && $validated['contact_number'] !== $resident->contact_number) {
            $requestedChanges['contact_number'] = $validated['contact_number'];
        }

        // If no changes, redirect back
        if (empty($requestedChanges)) {
            return redirect()->route('resident.profile.show')
                ->with('info', 'No changes were made to your profile');
        }

        // Create update request
        $updateRequest = UpdateRequest::create([
            'resident_id' => $resident->id,
            'status' => 'pending',
            'requested_changes' => $requestedChanges,
        ]);

        return redirect()->route('resident.update-requests')
            ->with('success', 'Your profile changes have been submitted for admin approval. You will be notified once they are processed.')
            ->with('success_timestamp', $updateRequest->created_at);
    }

    /**
     * Create guest visitor access request (for another car owner)
     */
    public function storeGuestAccess(Request $request)
    {
        $user = $request->user();
        $resident = $user->resident;

        if (!$resident) {
            return redirect()->back()->with('error', 'Resident profile not found');
        }

        // Validate incoming data for guest vehicle
        $validated = $request->validate([
            'guest_name' => 'required|string|max:255',
            'guest_age' => 'sometimes|nullable|integer|min:1|max:150',
            'guest_contact_number' => 'required|string|max:20',
            'guest_plate_number' => 'required|string|max:20',
            'guest_car_model' => 'required|string|max:255',
            'guest_car_color' => 'sometimes|nullable|string|max:100',
            'guest_address' => 'sometimes|nullable|string',
            'access_reason' => 'required|string|max:500',
            'access_date' => 'required|date|after_or_equal:today',
        ]);

        // Create guest access request
        UpdateRequest::create([
            'resident_id' => $resident->id,
            'status' => 'pending',
            'requested_changes' => array_merge($validated, [
                'request_type' => 'guest_access',
                'host_name' => $resident->name,
            ]),
        ]);

        return redirect()->route('resident.update-requests')
            ->with('success', 'Your guest access request has been submitted for admin approval. The visitor will be able to enter once approved.');
    }
}
