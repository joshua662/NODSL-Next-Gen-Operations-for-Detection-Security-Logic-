<?php

namespace App\Livewire\Admin;

use App\Models\Resident;
use App\Models\UpdateRequest;
use Livewire\Component;
use Livewire\WithPagination;

class UpdateRequests extends Component
{
    use WithPagination;

    public $statusFilter = 'pending';
    public $typeFilter = '';
    public $selectedRequest = null;
    public $showDetailModal = false;

    public function mount()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    public function approve($requestId)
    {
        $updateRequest = UpdateRequest::with('resident')->findOrFail($requestId);
        
        // Apply the requested changes
        $resident = $updateRequest->resident;
        $changes = $updateRequest->requested_changes;
        
        // Check if this is a guest access request
        $isGuestAccess = isset($changes['request_type']) && $changes['request_type'] === 'guest_access';
        
        if (!$isGuestAccess) {
            // For profile updates
            $resident->update($changes);
            
            // Update user if needed
            if (isset($changes['contact_number'])) {
                $resident->user->update(['phone' => $changes['contact_number']]);
            }
            if (isset($changes['plate_number'])) {
                $resident->user->update(['plate_number' => $changes['plate_number']]);
            }
        }
        
        // Mark request as approved
        $updateRequest->update([
            'status' => 'approved',
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        // Determine notification message based on request type
        $notificationTitle = 'Update Request Approved';
        $notificationMessage = 'Your profile update request has been approved.';
        
        if ($isGuestAccess) {
            $notificationTitle = '🚗 Guest Access Approved';
            $notificationMessage = 'Your guest vehicle access request has been approved! The vehicle with plate number ' . ($changes['guest_plate_number'] ?? 'N/A') . ' (' . ($changes['guest_name'] ?? 'Guest') . ') can now pass through the gate on ' . ($changes['access_date'] ?? 'the scheduled date') . '.';
        } elseif (isset($changes['is_personal_data_request']) && $changes['is_personal_data_request']) {
            $notificationTitle = 'Personal Data Access Approved';
            $notificationMessage = 'Your request to access personal data information for another car owner to enter the subdivision has been approved. You can now proceed with the guest access process.';
        }

        // Create notification for resident
        \App\Models\Notification::create([
            'user_id' => $resident->user_id,
            'type' => $isGuestAccess ? 'guest_access_approved' : 'update_approved',
            'title' => $notificationTitle,
            'message' => $notificationMessage,
            'update_request_id' => $updateRequest->id,
        ]);

        session()->flash('message', 'Request approved successfully.');
    }

    public function reject($requestId)
    {
        $updateRequest = UpdateRequest::findOrFail($requestId);
        
        // Check if this is a guest access request
        $isGuestAccess = isset($updateRequest->requested_changes['request_type']) && $updateRequest->requested_changes['request_type'] === 'guest_access';
        
        // For rejection, we'll need a reason - simplified for now
        $updateRequest->update([
            'status' => 'rejected',
            'reason' => 'Update rejected by admin',
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        // Determine notification message based on request type
        $notificationTitle = 'Update Request Rejected';
        $notificationMessage = 'Your profile update request has been rejected.';
        
        if ($isGuestAccess) {
            $notificationTitle = '🚗 Guest Access Request Rejected';
            $notificationMessage = 'Your guest vehicle access request for plate number ' . ($updateRequest->requested_changes['guest_plate_number'] ?? 'N/A') . ' has been rejected. Please contact the subdivision security office for more information.';
        } elseif (isset($updateRequest->requested_changes['is_personal_data_request']) && $updateRequest->requested_changes['is_personal_data_request']) {
            $notificationTitle = 'Personal Data Access Request Rejected';
            $notificationMessage = 'Your request to access personal data information for another car owner to enter the subdivision has been rejected. Please contact the subdivision security office for more information.';
        }

        // Create notification for resident
        \App\Models\Notification::create([
            'user_id' => $updateRequest->resident->user_id,
            'type' => $isGuestAccess ? 'guest_access_rejected' : 'update_rejected',
            'title' => $notificationTitle,
            'message' => $notificationMessage,
            'update_request_id' => $updateRequest->id,
        ]);

        session()->flash('message', 'Request rejected.');
        $this->closeDetailModal();
    }

    public function openDetailModal($requestId)
    {
        $this->selectedRequest = UpdateRequest::with(['resident', 'reviewer'])->findOrFail($requestId);
        $this->showDetailModal = true;
    }

    public function closeDetailModal()
    {
        $this->showDetailModal = false;
        $this->selectedRequest = null;
    }

    public function render()
    {
        $query = UpdateRequest::with(['resident', 'reviewer'])
            ->orderBy('created_at', 'desc');

        // ONLY show profile update requests (exclude guest access)
        $query->where(function ($q) {
            $q->whereNull('requested_changes->request_type')
              ->orWhereRaw("JSON_EXTRACT(requested_changes, '$.request_type') IS NULL");
        });

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        $requests = $query->paginate(15);

        return view('livewire.admin.update-requests', [
            'requests' => $requests,
        ]);
    }
}
