<?php

namespace App\Livewire\Admin;

use App\Models\UpdateRequest;
use Livewire\Component;
use Livewire\WithPagination;

class GuestAccessRequests extends Component
{
    use WithPagination;

    public $statusFilter = 'pending';
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
        
        // Mark request as approved
        $updateRequest->update([
            'status' => 'approved',
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        // Notification for guest access approval
        $notificationTitle = '🚗 Guest Access Approved';
        $notificationMessage = 'Your guest vehicle access request has been approved! The vehicle with plate number ' . ($updateRequest->requested_changes['guest_plate_number'] ?? 'N/A') . ' (' . ($updateRequest->requested_changes['guest_name'] ?? 'Guest') . ') can now pass through the gate on ' . ($updateRequest->requested_changes['access_date'] ?? 'the scheduled date') . '.';

        // Create notification for resident
        \App\Models\Notification::create([
            'user_id' => $updateRequest->resident->user_id,
            'type' => 'guest_access_approved',
            'title' => $notificationTitle,
            'message' => $notificationMessage,
            'update_request_id' => $updateRequest->id,
        ]);

        session()->flash('message', 'Guest access request approved successfully.');
        $this->closeDetailModal();
    }

    public function reject($requestId)
    {
        $updateRequest = UpdateRequest::findOrFail($requestId);
        
        // For rejection
        $updateRequest->update([
            'status' => 'rejected',
            'reason' => 'Guest access request rejected by admin',
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        // Notification for guest access rejection
        $notificationTitle = '🚗 Guest Access Request Rejected';
        $notificationMessage = 'Your guest vehicle access request for plate number ' . ($updateRequest->requested_changes['guest_plate_number'] ?? 'N/A') . ' has been rejected. Please contact the subdivision security office for more information.';

        // Create notification for resident
        \App\Models\Notification::create([
            'user_id' => $updateRequest->resident->user_id,
            'type' => 'guest_access_rejected',
            'title' => $notificationTitle,
            'message' => $notificationMessage,
            'update_request_id' => $updateRequest->id,
        ]);

        session()->flash('message', 'Guest access request rejected.');
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
            ->whereJsonContains('requested_changes->request_type', 'guest_access')
            ->orderBy('created_at', 'desc');

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        $requests = $query->paginate(15);

        return view('livewire.admin.guest-access-requests', [
            'requests' => $requests,
        ]);
    }
}
