<div class="space-y-6 w-full">
    <!-- Toast Container -->
    <div id="toast-container" class="fixed top-4 right-4 z-50 space-y-2"></div>

    <!-- Header Section -->
    <div class="bg-white dark:bg-zinc-800 rounded-xl p-6 border border-zinc-200 dark:border-zinc-700">
        <h2 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100 flex items-center gap-2">
            📝 Profile Update Requests
        </h2>
        <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Review and approve resident profile updates</p>
    </div>

    @if (session()->has('message'))
        <div class="rounded-lg bg-green-50 border border-green-200 dark:bg-green-900/20 dark:border-green-800 px-4 py-3 text-sm text-green-800 dark:text-green-200">
            {{ session('message') }}
        </div>
    @endif

    <!-- Statistics Section -->
    <div class="grid md:grid-cols-4 gap-4">
        @php
            $totalRequests = $requests->total();
            $pendingCount = $requests->filter(fn($r) => $r->status === 'pending')->count();
            $approvedCount = $requests->filter(fn($r) => $r->status === 'approved')->count();
            $rejectedCount = $requests->filter(fn($r) => $r->status === 'rejected')->count();
        @endphp
        
        <div class="bg-white dark:bg-zinc-800 rounded-xl p-4 border border-zinc-200 dark:border-zinc-700">
            <p class="text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase mb-2">Total Requests</p>
            <p class="text-3xl font-bold text-zinc-900 dark:text-zinc-100">{{ $totalRequests }}</p>
        </div>
        
        <div class="bg-yellow-50 dark:bg-yellow-900/20 rounded-xl p-4 border border-yellow-200 dark:border-yellow-700">
            <p class="text-xs font-semibold text-yellow-600 dark:text-yellow-400 uppercase mb-2">Pending</p>
            <p class="text-3xl font-bold text-yellow-700 dark:text-yellow-400">{{ $pendingCount }}</p>
        </div>
        
        <div class="bg-green-50 dark:bg-green-900/20 rounded-xl p-4 border border-green-200 dark:border-green-700">
            <p class="text-xs font-semibold text-green-600 dark:text-green-400 uppercase mb-2">Approved</p>
            <p class="text-3xl font-bold text-green-700 dark:text-green-400">{{ $approvedCount }}</p>
        </div>
        
        <div class="bg-red-50 dark:bg-red-900/20 rounded-xl p-4 border border-red-200 dark:border-red-700">
            <p class="text-xs font-semibold text-red-600 dark:text-red-400 uppercase mb-2">Rejected</p>
            <p class="text-3xl font-bold text-red-700 dark:text-red-400">{{ $rejectedCount }}</p>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-white dark:bg-zinc-800 rounded-xl p-6 border border-zinc-200 dark:border-zinc-700">
        <flux:select wire:model.live="statusFilter" label="Filter by Status">
            <option value="">All Statuses</option>
            <option value="pending">Pending</option>
            <option value="approved">Approved</option>
            <option value="rejected">Rejected</option>
        </flux:select>
    </div>

    <!-- Update Requests List -->
    <div class="space-y-3">
        @forelse ($requests as $request)
            <!-- Minimized Card -->
            <div wire:click="openDetailModal({{ $request->id }})" class="bg-white dark:bg-zinc-800 border border-blue-200 dark:border-blue-700 rounded-xl p-4 shadow-sm hover:shadow-md transition-all cursor-pointer hover:border-blue-400 dark:hover:border-blue-500">
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-4 flex-1">
                        <span class="inline-block px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 text-xs font-bold rounded-full">📝 PROFILE UPDATE</span>
                        <div class="flex-1 grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                            <div>
                                <p class="text-zinc-500 dark:text-zinc-400 text-xs">Resident</p>
                                <p class="font-semibold text-zinc-900 dark:text-zinc-100">{{ $request->resident->name }}</p>
                            </div>
                            <div>
                                <p class="text-zinc-500 dark:text-zinc-400 text-xs">Resident ID</p>
                                <p class="font-medium text-zinc-900 dark:text-zinc-100">#{{ $request->resident->id }}</p>
                            </div>
                            <div>
                                <p class="text-zinc-500 dark:text-zinc-400 text-xs">Current Plate</p>
                                <p class="font-mono text-zinc-900 dark:text-zinc-100">{{ $request->resident->plate_number ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-zinc-500 dark:text-zinc-400 text-xs">Submitted</p>
                                <p class="text-zinc-900 dark:text-zinc-100">{{ $request->created_at->format('M d, Y g:i A') }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 ml-4">
                        <span class="px-3 py-1 text-xs font-medium rounded-full whitespace-nowrap
                            {{ $request->status === 'approved' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-200' : 
                               ($request->status === 'rejected' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-200' : 
                               'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-200') }}">
                            {{ ucfirst($request->status) }}
                        </span>
                        <svg class="w-5 h-5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>
            </div>
        @empty
            <div class="bg-white dark:bg-zinc-800 border border-zinc-200 dark:border-zinc-700 rounded-xl p-12 text-center text-zinc-500">
                <p class="text-lg">📭 No profile update requests found</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="bg-white dark:bg-zinc-800 rounded-xl p-6 border border-zinc-200 dark:border-zinc-700">
        {{ $requests->links() }}
    </div>

    <!-- Information & Features Section -->
    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700 rounded-xl p-6">
        <h3 class="text-lg font-semibold text-blue-900 dark:text-blue-100 mb-3">📝 Profile Update Requests</h3>
        <ul class="text-sm text-blue-800 dark:text-blue-300 space-y-2">
            <li>✓ Residents can update personal information</li>
            <li>✓ Modify vehicle details (plate, model, color)</li>
            <li>✓ Update contact numbers</li>
            <li>✓ Change residential address</li>
            <li>✓ Request access to other owner's personal data for subdivision entry</li>
            <li>✓ All changes require admin approval</li>
            <li>✓ Residents receive notifications upon decision</li>
            <li>✓ Guest vehicle access requests are managed separately</li>
        </ul>
    </div>

    <!-- Detail Modal -->
    @if ($showDetailModal && $selectedRequest)
        <div class="fixed inset-0 z-50 overflow-y-auto" wire:click="closeDetailModal">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:p-0">
                <div class="fixed inset-0 bg-white/80 dark:bg-zinc-900/80 backdrop-blur-sm transition-opacity" wire:click="closeDetailModal"></div>
                <div class="relative inline-block align-middle bg-white dark:bg-zinc-800 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:max-w-4xl sm:w-full" wire:click.stop>
                    <div class="px-8 pt-6 pb-6">
                        <!-- Header -->
                        <div class="flex justify-between items-start mb-6 pb-4 border-b border-zinc-200 dark:border-zinc-700">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-3">
                                    <span class="inline-block px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 text-xs font-bold rounded-full">📝 PROFILE UPDATE</span>
                                    <h3 class="text-xl font-semibold text-zinc-900 dark:text-zinc-100">{{ $selectedRequest->resident->name }}</h3>
                                </div>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                    <div>
                                        <p class="text-zinc-500 dark:text-zinc-400">Resident ID</p>
                                        <p class="font-medium text-zinc-900 dark:text-zinc-100">#{{ $selectedRequest->resident->id }}</p>
                                    </div>
                                    <div>
                                        <p class="text-zinc-500 dark:text-zinc-400">Current Plate</p>
                                        <p class="font-mono text-zinc-900 dark:text-zinc-100">{{ $selectedRequest->resident->plate_number ?? 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-zinc-500 dark:text-zinc-400">Email</p>
                                        <p class="text-zinc-900 dark:text-zinc-100">{{ $selectedRequest->resident->user->email ?? 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-zinc-500 dark:text-zinc-400">Submitted</p>
                                        <p class="text-zinc-900 dark:text-zinc-100">{{ $selectedRequest->created_at->format('M d, Y g:i A') }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 ml-4">
                                <span class="px-4 py-2 text-sm font-medium rounded-full whitespace-nowrap
                                    {{ $selectedRequest->status === 'approved' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-200' : 
                                       ($selectedRequest->status === 'rejected' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-200' : 
                                       'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-200') }}">
                                    {{ ucfirst($selectedRequest->status) }}
                                </span>
                                <button wire:click="closeDetailModal" class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Changes Section -->
                        <div class="mb-6 pb-4 border-b border-zinc-200 dark:border-zinc-700">
                            <h4 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100 mb-3">📋 Requested Changes</h4>
                            <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4">
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    @foreach($selectedRequest->requested_changes as $key => $value)
                                        @if($key === 'is_personal_data_request' && $value)
                                            <div class="col-span-full border border-blue-200 dark:border-blue-600 rounded p-3 bg-blue-100 dark:bg-blue-900/30">
                                                <p class="text-sm">
                                                    <strong class="text-blue-600 dark:text-blue-400">🔐 Personal Data Access:</strong>
                                                    <span class="text-zinc-700 dark:text-zinc-300">Access to another car owner's information for subdivision entry</span>
                                                </p>
                                            </div>
                                        @elseif($key !== 'is_personal_data_request' && $key !== 'request_type')
                                            <div class="border border-blue-200 dark:border-blue-600 rounded p-3 bg-white dark:bg-zinc-800">
                                                <p class="text-xs font-semibold text-blue-600 dark:text-blue-400 uppercase mb-1">{{ ucfirst(str_replace('_', ' ', $key)) }}</p>
                                                <p class="text-sm text-zinc-900 dark:text-zinc-100 font-mono break-words">{{ $value }}</p>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="flex justify-between items-center">
                            <div class="text-xs text-zinc-500">
                                @if($selectedRequest->reviewed_by)
                                    Reviewed by <strong>{{ $selectedRequest->reviewer->name }}</strong> on {{ $selectedRequest->reviewed_at->format('M d, Y') }}
                                @endif
                            </div>

                            @if($selectedRequest->status === 'pending')
                                <div class="flex gap-2">
                                    <flux:button wire:click="approve({{ $selectedRequest->id }})" variant="primary" size="sm" class="px-4">✓ Approve</flux:button>
                                    <flux:button wire:click="reject({{ $selectedRequest->id }})" variant="ghost" size="sm" class="text-red-600 px-4">✕ Reject</flux:button>
                                </div>
                            @elseif($selectedRequest->reason)
                                <p class="text-sm text-zinc-600 dark:text-zinc-400"><strong>Reason:</strong> {{ $selectedRequest->reason }}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<script>
    function showToast(title, message, type = 'success') {
        const container = document.getElementById('toast-container');
        
        const bgColor = type === 'success' ? 'bg-green-600' : 
                      type === 'error' ? 'bg-red-600' : 
                      type === 'warning' ? 'bg-yellow-600' : 'bg-blue-600';
        
        const icon = type === 'success' ? '✓' : 
                    type === 'error' ? '✕' : 
                    type === 'warning' ? '⚠' : 'ℹ';
        
        const toast = document.createElement('div');
        toast.className = `${bgColor} text-white px-4 py-3 rounded-lg shadow-lg flex items-start gap-3 max-w-sm animate-in fade-in slide-in-from-top-2 duration-300`;
        toast.innerHTML = `
            <div class="flex-shrink-0 text-lg font-bold">${icon}</div>
            <div class="flex-1">
                <p class="font-semibold text-sm">${title}</p>
                <p class="text-xs opacity-90">${message}</p>
            </div>
        `;
        
        container.appendChild(toast);
        
        setTimeout(() => {
            toast.classList.add('animate-out', 'fade-out', 'slide-out-to-top-2', 'duration-300');
            setTimeout(() => toast.remove(), 300);
        }, 3000);
    }

    // Show toast on Livewire events
    Livewire.on('approveRequest', (requestId) => {
        showToast('✓ Approved', 'Profile update request has been approved.', 'success');
    });

    Livewire.on('rejectRequest', (requestId) => {
        showToast('✕ Rejected', 'Profile update request has been rejected.', 'success');
    });
</script>
