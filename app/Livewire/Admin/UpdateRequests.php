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
        
        $resident->update($changes);
        
        // Update user if needed
        if (isset($changes['contact_number'])) {
            $resident->user->update(['phone' => $changes['contact_number']]);
        }
        if (isset($changes['plate_number'])) {
            $resident->user->update(['plate_number' => $changes['plate_number']]);
        }
        
        // Mark request as approved
        $updateRequest->update([
            'status' => 'approved',
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        // Create notification for resident
        \App\Models\Notification::create([
            'user_id' => $resident->user_id,
            'type' => 'update_approved',
            'title' => 'Update Request Approved',
            'message' => 'Your profile update request has been approved.',
            'update_request_id' => $updateRequest->id,
        ]);

        session()->flash('message', 'Update request approved successfully.');
    }

    public function reject($requestId)
    {
        $updateRequest = UpdateRequest::findOrFail($requestId);
        
        // For rejection, we'll need a reason - simplified for now
        $updateRequest->update([
            'status' => 'rejected',
            'reason' => 'Update rejected by admin',
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);

        // Create notification for resident
        \App\Models\Notification::create([
            'user_id' => $updateRequest->resident->user_id,
            'type' => 'update_rejected',
            'title' => 'Update Request Rejected',
            'message' => 'Your profile update request has been rejected.',
            'update_request_id' => $updateRequest->id,
        ]);

        session()->flash('message', 'Update request rejected.');
    }

    public function render()
    {
        $query = UpdateRequest::with(['resident', 'reviewer'])->orderBy('created_at', 'desc');

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        $requests = $query->paginate(15);

        return view('livewire.admin.update-requests', [
            'requests' => $requests,
        ]);
    }
}
