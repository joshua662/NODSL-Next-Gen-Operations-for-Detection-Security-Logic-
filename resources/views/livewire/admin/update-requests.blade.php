<div class="space-y-6">
    <div>
        <h2 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">Update Requests</h2>
        <p class="text-sm text-zinc-600 dark:text-zinc-400">Review and approve resident profile update requests</p>
    </div>

    @if (session()->has('message'))
        <div class="rounded-lg bg-green-50 border border-green-200 dark:bg-green-900/20 dark:border-green-800 px-4 py-3 text-sm text-green-800 dark:text-green-200">
            {{ session('message') }}
        </div>
    @endif

    <div>
        <flux:select wire:model.live="statusFilter" label="Filter by Status">
            <option value="">All</option>
            <option value="pending">Pending</option>
            <option value="approved">Approved</option>
            <option value="rejected">Rejected</option>
        </flux:select>
    </div>

    <div class="space-y-4">
        @forelse ($requests as $request)
            <div class="border border-zinc-200 dark:border-zinc-700 rounded-lg p-4">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <h3 class="font-semibold">{{ $request->resident->name }}</h3>
                        <p class="text-sm text-zinc-600 dark:text-zinc-400">Plate: {{ $request->resident->plate_number }}</p>
                        <p class="text-xs text-zinc-500">Submitted: {{ $request->created_at->format('M d, Y g:i A') }}</p>
                    </div>
                    <span class="px-3 py-1 text-xs rounded-full 
                        {{ $request->status === 'approved' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200' : 
                           ($request->status === 'rejected' ? 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200' : 
                           'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200') }}">
                        {{ ucfirst($request->status) }}
                    </span>
                </div>

                <div class="mb-4">
                    <h4 class="text-sm font-semibold mb-2">Requested Changes:</h4>
                    <ul class="list-disc list-inside text-sm space-y-1">
                        @foreach($request->requested_changes as $key => $value)
                            <li><strong>{{ ucfirst(str_replace('_', ' ', $key)) }}:</strong> {{ $value }}</li>
                        @endforeach
                    </ul>
                </div>

                @if($request->status === 'pending')
                    <div class="flex gap-2">
                        <flux:button wire:click="approve({{ $request->id }})" variant="primary" size="sm">Approve</flux:button>
                        <flux:button wire:click="reject({{ $request->id }})" variant="ghost" size="sm" class="text-red-600">Reject</flux:button>
                    </div>
                @elseif($request->reason)
                    <p class="text-sm text-zinc-600 dark:text-zinc-400"><strong>Reason:</strong> {{ $request->reason }}</p>
                @endif

                @if($request->reviewed_by)
                    <p class="text-xs text-zinc-500 mt-2">Reviewed by {{ $request->reviewer->name }} on {{ $request->reviewed_at->format('M d, Y g:i A') }}</p>
                @endif
            </div>
        @empty
            <div class="text-center py-8 text-zinc-500">No update requests found</div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $requests->links() }}
    </div>
</div>
