<?php

namespace App\Livewire\Admin;

use App\Models\GateLog;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class Reports extends Component
{
    public $dateRange = 'week';
    public $startDate;
    public $endDate;

    public function mount()
    {
        if (!auth()->user()->isAdmin()) {
            abort(403);
        }
    }

    public function updatedDateRange()
    {
        $this->calculateDateRange();
    }

    public function calculateDateRange()
    {
        $now = now();
        switch ($this->dateRange) {
            case 'today':
                $this->startDate = $now->copy()->startOfDay()->toDateString();
                $this->endDate = $now->copy()->endOfDay()->toDateString();
                break;
            case 'week':
                $this->startDate = $now->copy()->startOfWeek()->toDateString();
                $this->endDate = $now->copy()->endOfWeek()->toDateString();
                break;
            case 'month':
                $this->startDate = $now->copy()->startOfMonth()->toDateString();
                $this->endDate = $now->copy()->endOfMonth()->toDateString();
                break;
            default:
                $this->startDate = $now->copy()->startOfWeek()->toDateString();
                $this->endDate = $now->copy()->endOfWeek()->toDateString();
        }
    }


    public function render()
    {
        $this->calculateDateRange();

        $stats = GateLog::whereBetween('timestamp', [$this->startDate, $this->endDate])
            ->selectRaw('
                COUNT(*) as total_entries,
                SUM(CASE WHEN status = "authorized" THEN 1 ELSE 0 END) as authorized_count,
                SUM(CASE WHEN status = "unauthorized" THEN 1 ELSE 0 END) as unauthorized_count
            ')
            ->first();

        $dailyStats = GateLog::whereBetween('timestamp', [$this->startDate, $this->endDate])
            ->selectRaw('DATE(timestamp) as date, COUNT(*) as count, status')
            ->groupBy('date', 'status')
            ->orderBy('date')
            ->get()
            ->groupBy('date');

        return view('livewire.admin.reports', [
            'stats' => $stats,
            'dailyStats' => $dailyStats,
        ]);
    }
}
