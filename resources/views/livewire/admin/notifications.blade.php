<div class="space-y-6">
    <div>
        <h2 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">Notifications</h2>
        <p class="text-sm text-zinc-600 dark:text-zinc-400">View system alerts and important notifications</p>
    </div>

    <div class="space-y-4">
        @forelse ($notifications as $notification)
            <div class="border border-zinc-200 dark:border-zinc-700 rounded-lg p-4 {{ !$notification->is_read ? 'bg-blue-50 dark:bg-blue-900/20' : '' }}">
                <div class="flex justify-between items-start">
                    <div class="flex-1">
                        <h3 class="font-semibold">{{ $notification->title }}</h3>
                        <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">{{ $notification->message }}</p>
                        <p class="text-xs text-zinc-500 mt-2">{{ $notification->created_at->format('M d, Y g:i A') }}</p>
                    </div>
                    @if(!$notification->is_read)
                        <flux:button wire:click="markAsRead({{ $notification->id }})" variant="ghost" size="sm">Mark as Read</flux:button>
                    @endif
                </div>
            </div>
        @empty
            <div class="text-center py-8 text-zinc-500">No notifications</div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $notifications->links() }}
    </div>
</div>
