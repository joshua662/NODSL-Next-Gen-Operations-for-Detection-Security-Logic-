<?php

namespace App\Livewire\Admin;

use App\Models\GateLog;
use Livewire\Component;
use Livewire\WithPagination;

class GateLogs extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = '';

    public function mount()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = GateLog::with('resident')->orderBy('timestamp', 'desc');

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('plate_number', 'like', '%' . $this->search . '%')
                  ->orWhere('owner_name', 'like', '%' . $this->search . '%');
            });
        }

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        $logs = $query->paginate(20);

        return view('livewire.admin.gate-logs', [
            'logs' => $logs,
        ]);
    }
}
