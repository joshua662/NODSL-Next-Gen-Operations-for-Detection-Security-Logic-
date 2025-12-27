<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">Reports & Analytics</h2>
            <p class="text-sm text-zinc-600 dark:text-zinc-400">View gate traffic statistics and export logs</p>
        </div>
        <a href="{{ route('admin.reports.export', ['date_range' => $dateRange]) }}" class="inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700">Export CSV</a>
    </div>

    <div>
        <flux:select wire:model.live="dateRange" label="Date Range">
            <option value="today">Today</option>
            <option value="week">This Week</option>
            <option value="month">This Month</option>
        </flux:select>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div class="border border-zinc-200 dark:border-zinc-700 rounded-lg p-4">
            <h3 class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Total Entries</h3>
            <p class="text-3xl font-bold mt-2">{{ $stats->total_entries ?? 0 }}</p>
        </div>
        <div class="border border-zinc-200 dark:border-zinc-700 rounded-lg p-4">
            <h3 class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Authorized</h3>
            <p class="text-3xl font-bold text-green-600 dark:text-green-400 mt-2">{{ $stats->authorized_count ?? 0 }}</p>
        </div>
        <div class="border border-zinc-200 dark:border-zinc-700 rounded-lg p-4">
            <h3 class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Unauthorized</h3>
            <p class="text-3xl font-bold text-red-600 dark:text-red-400 mt-2">{{ $stats->unauthorized_count ?? 0 }}</p>
        </div>
    </div>

    <div class="border border-zinc-200 dark:border-zinc-700 rounded-lg p-4">
        <h3 class="text-lg font-semibold mb-4">Daily Statistics</h3>
        <div class="space-y-2">
            @forelse ($dailyStats as $date => $statGroup)
                <div class="flex items-center justify-between p-2 bg-zinc-50 dark:bg-zinc-800 rounded">
                    <span class="font-medium">{{ \Carbon\Carbon::parse($date)->format('M d, Y') }}</span>
                    <div class="flex gap-4">
                        <span class="text-sm">Total: {{ $statGroup->sum('count') }}</span>
                        <span class="text-sm text-green-600">Authorized: {{ $statGroup->where('status', 'authorized')->sum('count') }}</span>
                        <span class="text-sm text-red-600">Unauthorized: {{ $statGroup->where('status', 'unauthorized')->sum('count') }}</span>
                    </div>
                </div>
            @empty
                <p class="text-zinc-500 text-center py-4">No data available for selected period</p>
            @endforelse
        </div>
    </div>
</div>
