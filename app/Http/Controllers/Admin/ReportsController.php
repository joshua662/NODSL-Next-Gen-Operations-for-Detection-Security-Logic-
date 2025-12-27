<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GateLog;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ReportsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function exportCsv(Request $request): Response
    {
        $dateRange = $request->input('date_range', 'week');
        $startDate = $this->calculateStartDate($dateRange);
        $endDate = $this->calculateEndDate($dateRange);
        
        $logs = GateLog::whereBetween('timestamp', [$startDate, $endDate])
            ->orderBy('timestamp', 'desc')
            ->get();

        $filename = 'gate-logs-' . now()->format('Y-m-d') . '.csv';

        $callback = function() use ($logs) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Timestamp', 'Plate Number', 'Owner Name', 'Car Model', 'Car Color', 'Status']);
            
            foreach ($logs as $log) {
                fputcsv($file, [
                    $log->timestamp->format('Y-m-d H:i:s'),
                    $log->plate_number,
                    $log->owner_name ?? 'N/A',
                    $log->car_model ?? 'N/A',
                    $log->car_color ?? 'N/A',
                    $log->status,
                ]);
            }
            
            fclose($file);
        };

        return response()->streamDownload($callback, $filename, [
            'Content-Type' => 'text/csv',
        ]);
    }

    private function calculateStartDate(string $range): string
    {
        $now = now();
        switch ($range) {
            case 'today':
                return $now->copy()->startOfDay()->toDateString();
            case 'week':
                return $now->copy()->startOfWeek()->toDateString();
            case 'month':
                return $now->copy()->startOfMonth()->toDateString();
            default:
                return $now->copy()->startOfWeek()->toDateString();
        }
    }

    private function calculateEndDate(string $range): string
    {
        $now = now();
        switch ($range) {
            case 'today':
                return $now->copy()->endOfDay()->toDateString();
            case 'week':
                return $now->copy()->endOfWeek()->toDateString();
            case 'month':
                return $now->copy()->endOfMonth()->toDateString();
            default:
                return $now->copy()->endOfWeek()->toDateString();
        }
    }
}
