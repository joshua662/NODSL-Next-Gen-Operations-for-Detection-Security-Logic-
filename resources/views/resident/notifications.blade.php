<x-layouts.app :title="__('Notifications')">
    <div class="flex h-full w-full flex-1 flex-col gap-4">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-zinc-900 dark:text-zinc-100">🔔 Notifications</h1>
            <p class="text-zinc-600 dark:text-zinc-400 mt-1">Stay updated on gate access alerts and system messages</p>
        </div>

        @php
            $notifications = auth()->user()->notifications()->latest()->paginate(20);
            $unreadCount = auth()->user()->notifications()->where('is_read', false)->count();
        @endphp

        <!-- Filter & Actions -->
        <div class="flex items-center justify-between mb-6 flex-wrap gap-3">
            <div class="flex items-center gap-2">
                @if($unreadCount > 0)
                    <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 text-sm font-medium rounded-full">
                        {{ $unreadCount }} Unread
                    </span>
                @endif
            </div>
            @if($unreadCount > 0)
                <form action="{{ route('resident.notifications.mark-all-read') ?? '#' }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit" class="text-sm text-blue-600 dark:text-blue-400 hover:underline font-medium">
                        Mark all as read
                    </button>
                </form>
            @endif
        </div>

        <!-- Notifications List -->
        <div class="space-y-3">
            @if($notifications->count() > 0)
                @foreach($notifications as $notification)
                    <div class="border-l-4 {{ $notification->is_read ? 'border-zinc-300 dark:border-zinc-600 bg-zinc-50 dark:bg-zinc-900' : 'border-blue-500 bg-blue-50 dark:bg-blue-900/20' }} p-4 rounded-r-lg">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 mb-1">
                                    <h3 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100">
                                        {{ $notification->title ?? 'System Notification' }}
                                    </h3>
                                    @if(!$notification->is_read)
                                        <span class="inline-block w-2 h-2 bg-blue-500 rounded-full"></span>
                                    @endif
                                </div>
                                <p class="text-sm text-zinc-700 dark:text-zinc-300 mb-2">
                                    {{ $notification->message }}
                                </p>
                                
                                <!-- Notification Type Badge -->
                                @php
                                    $type = $notification->type ?? 'general';
                                    $colors = [
                                        'gate_access' => 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400',
                                        'unauthorized' => 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400',
                                        'update_approved' => 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400',
                                        'update_rejected' => 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400',
                                        'system' => 'bg-slate-100 dark:bg-slate-900/30 text-slate-700 dark:text-slate-400',
                                        'general' => 'bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400',
                                    ];
                                    $icon = [
                                        'gate_access' => '✓ Gate Access',
                                        'unauthorized' => '⚠ Unauthorized',
                                        'update_approved' => '✓ Approved',
                                        'update_rejected' => '✗ Rejected',
                                        'system' => '⚙ System',
                                        'general' => 'ℹ General',
                                    ];
                                @endphp
                                
                                <div class="flex items-center justify-between flex-wrap gap-2">
                                    <span class="inline-block px-2 py-1 text-xs font-medium rounded {{ $colors[$type] ?? $colors['general'] }}">
                                        {{ $icon[$type] ?? $icon['general'] }}
                                    </span>
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400">
                                        {{ $notification->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>

                            <!-- Mark as read button -->
                            @if(!$notification->is_read)
                                <form action="{{ route('resident.notifications.mark-read', $notification->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" title="Mark as read" class="text-zinc-400 dark:text-zinc-500 hover:text-zinc-600 dark:hover:text-zinc-400 transition">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"/>
                                        </svg>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach

                <!-- Pagination -->
                <div class="pt-6">
                    {{ $notifications->links() }}
                </div>
            @else
                <div class="text-center py-12 border border-zinc-200 dark:border-zinc-700 rounded-xl">
                    <p class="text-zinc-500 dark:text-zinc-400 text-lg">🎉 No notifications</p>
                    <p class="text-zinc-500 dark:text-zinc-400 text-sm mt-2">You're all caught up!</p>
                </div>
            @endif
        </div>

        <!-- Help Section -->
        <div class="mt-8 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
            <h3 class="text-sm font-semibold text-blue-900 dark:text-blue-200 mb-2">📢 Notification Types</h3>
            <ul class="text-sm text-blue-800 dark:text-blue-300 space-y-1">
                <li><strong>✓ Gate Access:</strong> When you successfully enter or exit the subdivision</li>
                <li><strong>⚠ Unauthorized:</strong> When there's an unauthorized access attempt with your plate</li>
                <li><strong>✓ Approved:</strong> When your profile update request is approved by admin</li>
                <li><strong>✗ Rejected:</strong> When your profile update request is rejected</li>
                <li><strong>⚙ System:</strong> Important system announcements and maintenance notices</li>
            </ul>
        </div>
    </div>
</x-layouts.app>
