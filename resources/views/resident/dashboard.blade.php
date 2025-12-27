<x-layouts.app :title="__('Resident Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-zinc-900 dark:text-zinc-100">Welcome, {{ auth()->user()->resident->name }}!</h1>
            <p class="text-zinc-600 dark:text-zinc-400 mt-1">Gate Security System - Resident Portal</p>
        </div>

        <!-- Quick Summary of Latest Gate Activity -->
        <div class="grid gap-4 md:grid-cols-3 lg:grid-cols-3 mb-6">
            <!-- Last Entry -->
            <div class="border border-zinc-200 dark:border-zinc-700 rounded-xl p-6 bg-zinc-50 dark:bg-zinc-900">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Last Entry</h3>
                    <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2 11a1 1 0 011-1h2a1 1 0 011 1v5a1 1 0 01-1 1H3a1 1 0 01-1-1v-5zM8 7a1 1 0 011-1h2a1 1 0 011 1v9a1 1 0 01-1 1H9a1 1 0 01-1-1V7zM14 4a1 1 0 011-1h2a1 1 0 011 1v12a1 1 0 01-1 1h-2a1 1 0 01-1-1V4z"/>
                    </svg>
                </div>
                @php
                    $lastEntry = auth()->user()->resident->gateLogs()->where('status', 'entry')->latest()->first();
                @endphp
                @if($lastEntry)
                    <p class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">{{ $lastEntry->timestamp->format('H:i') }}</p>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-2">{{ $lastEntry->timestamp->format('M d, Y') }}</p>
                    <p class="text-xs text-green-600 dark:text-green-400 mt-1">✓ AUTHORIZED</p>
                @else
                    <p class="text-lg text-zinc-500 dark:text-zinc-400">No entries yet</p>
                @endif
            </div>

            <!-- Last Exit -->
            <div class="border border-zinc-200 dark:border-zinc-700 rounded-xl p-6 bg-zinc-50 dark:bg-zinc-900">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Last Exit</h3>
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 6H6.28l-.31-1.243A1 1 0 005 4H3z"/>
                    </svg>
                </div>
                @php
                    $lastExit = auth()->user()->resident->gateLogs()->where('status', 'exit')->latest()->first();
                @endphp
                @if($lastExit)
                    <p class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">{{ $lastExit->timestamp->format('H:i') }}</p>
                    <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-2">{{ $lastExit->timestamp->format('M d, Y') }}</p>
                    <p class="text-xs text-blue-600 dark:text-blue-400 mt-1">✓ AUTHORIZED</p>
                @else
                    <p class="text-lg text-zinc-500 dark:text-zinc-400">No exits yet</p>
                @endif
            </div>

            <!-- Status Summary -->
            <div class="border border-zinc-200 dark:border-zinc-700 rounded-xl p-6 bg-zinc-50 dark:bg-zinc-900">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-sm font-medium text-zinc-600 dark:text-zinc-400">Access Status</h3>
                    <svg class="w-5 h-5 text-zinc-600 dark:text-zinc-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
                    </svg>
                </div>
                @php
                    $totalLogs = auth()->user()->resident->gateLogs()->count();
                    $unauthorizedCount = auth()->user()->resident->gateLogs()->where('status', 'unauthorized')->count();
                @endphp
                <p class="text-2xl font-bold text-green-600 dark:text-green-400">Authorized</p>
                <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-2">{{ $totalLogs }} total accesses</p>
                @if($unauthorizedCount > 0)
                    <p class="text-xs text-red-600 dark:text-red-400 mt-1">⚠ {{ $unauthorizedCount }} unauthorized attempts</p>
                @endif
            </div>
        </div>

        <!-- Notification Preview & Quick Links -->
        <div class="grid gap-4 lg:grid-cols-3">
            <!-- Notifications Preview -->
            <div class="lg:col-span-2 border border-zinc-200 dark:border-zinc-700 rounded-xl p-6 bg-white dark:bg-zinc-800">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">🔔 Recent Notifications</h2>
                    <a href="{{ route('resident.notifications') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:underline">View All</a>
                </div>
                @php
                    $notifications = auth()->user()->notifications()->latest()->take(5)->get();
                @endphp
                @if($notifications->count() > 0)
                    <div class="space-y-3">
                        @foreach($notifications as $notification)
                            <div class="border-l-4 border-blue-500 bg-blue-50 dark:bg-blue-900/20 p-3 rounded">
                                <p class="text-sm font-medium text-zinc-900 dark:text-zinc-100">{{ $notification->title ?? 'System Alert' }}</p>
                                <p class="text-xs text-zinc-600 dark:text-zinc-400 mt-1">{{ Str::limit($notification->message, 100) }}</p>
                                <p class="text-xs text-zinc-500 dark:text-zinc-500 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-center text-zinc-500 dark:text-zinc-400 py-6">No notifications yet</p>
                @endif
            </div>

            <!-- Quick Links -->
            <div class="border border-zinc-200 dark:border-zinc-700 rounded-xl p-6 bg-white dark:bg-zinc-800">
                <h2 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100 mb-4">Quick Links</h2>
                <div class="space-y-3">
                    <a href="{{ route('resident.profile.show') }}" class="flex items-center gap-3 p-3 hover:bg-zinc-100 dark:hover:bg-zinc-700 rounded-lg transition">
                        <span class="text-xl">👤</span>
                        <div>
                            <p class="text-sm font-medium text-zinc-900 dark:text-zinc-100">My Profile</p>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400">View details</p>
                        </div>
                    </a>
                    <a href="{{ route('resident.gate-logs') }}" class="flex items-center gap-3 p-3 hover:bg-zinc-100 dark:hover:bg-zinc-700 rounded-lg transition">
                        <span class="text-xl">📊</span>
                        <div>
                            <p class="text-sm font-medium text-zinc-900 dark:text-zinc-100">Gate Logs</p>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400">IN/OUT history</p>
                        </div>
                    </a>
                    <a href="{{ route('resident.update-requests') }}" class="flex items-center gap-3 p-3 hover:bg-zinc-100 dark:hover:bg-zinc-700 rounded-lg transition">
                        <span class="text-xl">📤</span>
                        <div>
                            <p class="text-sm font-medium text-zinc-900 dark:text-zinc-100">Update Request</p>
                            <p class="text-xs text-zinc-500 dark:text-zinc-400">Track status</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
