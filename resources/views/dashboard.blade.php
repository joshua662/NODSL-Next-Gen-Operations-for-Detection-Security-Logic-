<x-layouts.app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="mb-4">
            <h1 class="text-3xl font-bold text-zinc-900 dark:text-zinc-100">Welcome, {{ auth()->user()->name }}!</h1>
            <p class="text-zinc-600 dark:text-zinc-400 mt-1">
                @if(auth()->user()->isAdmin())
                    Gate Security System - Admin Dashboard
                @else
                    Gate Security System - Resident Portal
                @endif
            </p>
        </div>

        @if(auth()->user()->isAdmin())
            <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                <div class="border border-zinc-200 dark:border-zinc-700 rounded-xl p-6 bg-zinc-50 dark:bg-zinc-900">
                    <h3 class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Total Residents</h3>
                    <p class="text-3xl font-bold mt-2">{{ \App\Models\Resident::count() }}</p>
                </div>
                <div class="border border-zinc-200 dark:border-zinc-700 rounded-xl p-6 bg-zinc-50 dark:bg-zinc-900">
                    <h3 class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Today's Entries</h3>
                    <p class="text-3xl font-bold mt-2">{{ \App\Models\GateLog::whereDate('timestamp', today())->count() }}</p>
                </div>
                <div class="border border-zinc-200 dark:border-zinc-700 rounded-xl p-6 bg-zinc-50 dark:bg-zinc-900">
                    <h3 class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Pending Requests</h3>
                    <p class="text-3xl font-bold mt-2">{{ \App\Models\UpdateRequest::where('status', 'pending')->count() }}</p>
                </div>
                <div class="border border-zinc-200 dark:border-zinc-700 rounded-xl p-6 bg-zinc-50 dark:bg-zinc-900">
                    <h3 class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Unauthorized Today</h3>
                    <p class="text-3xl font-bold text-red-600 dark:text-red-400 mt-2">{{ \App\Models\GateLog::whereDate('timestamp', today())->where('status', 'unauthorized')->count() }}</p>
                </div>
            </div>

            <div class="border border-zinc-200 dark:border-zinc-700 rounded-xl p-6">
                <h2 class="text-xl font-bold mb-4">Quick Actions</h2>
                <div class="grid gap-4 md:grid-cols-2 lg:grid-cols-4">
                    <flux:button :href="route('admin.residents')" variant="primary" class="w-full">Manage Residents</flux:button>
                    <flux:button :href="route('admin.gate-logs')" variant="outline" class="w-full">View Gate Logs</flux:button>
                    <flux:button :href="route('admin.update-requests')" variant="outline" class="w-full">Review Requests</flux:button>
                    <flux:button :href="route('admin.reports')" variant="outline" class="w-full">View Reports</flux:button>
                </div>
            </div>
        @else
            <div class="grid gap-4 md:grid-cols-2">
                <div class="border border-zinc-200 dark:border-zinc-700 rounded-xl p-6 bg-zinc-50 dark:bg-zinc-900">
                    <h3 class="text-lg font-semibold mb-2">Your Profile</h3>
                    @if(auth()->user()->resident)
                        <p class="text-sm text-zinc-600 dark:text-zinc-400">Plate Number: <strong>{{ auth()->user()->resident->plate_number }}</strong></p>
                        <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Contact: <strong>{{ auth()->user()->resident->contact_number }}</strong></p>
                    @else
                        <p class="text-sm text-zinc-600 dark:text-zinc-400">Complete your profile to get started</p>
                    @endif
                </div>
                <div class="border border-zinc-200 dark:border-zinc-700 rounded-xl p-6 bg-zinc-50 dark:bg-zinc-900">
                    <h3 class="text-lg font-semibold mb-2">Recent Activity</h3>
                    <p class="text-sm text-zinc-600 dark:text-zinc-400">
                        @if(auth()->user()->resident)
                            Last gate entry: 
                            @php
                                $lastLog = auth()->user()->resident->gateLogs()->latest('timestamp')->first();
                            @endphp
                            @if($lastLog)
                                <strong>{{ $lastLog->timestamp->format('M d, Y g:i A') }}</strong> - 
                                <span class="{{ $lastLog->status === 'authorized' ? 'text-green-600' : 'text-red-600' }}">
                                    {{ ucfirst($lastLog->status) }}
                                </span>
                            @else
                                No entries yet
                            @endif
                        @else
                            No activity yet
                        @endif
                    </p>
                </div>
            </div>
        @endif
    </div>
</x-layouts.app>
