<div class="space-y-6 w-full">
    <!-- Toast Container -->
    <div id="toast-container" class="fixed top-4 right-4 z-50 space-y-2"></div>

    <!-- Header Section -->
    <div class="bg-white dark:bg-zinc-800 rounded-xl p-6 border border-zinc-200 dark:border-zinc-700">
        <h2 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100 flex items-center gap-2">
            🚗 Guest Access Requests
        </h2>
        <p class="text-sm text-zinc-600 dark:text-zinc-400 mt-1">Review and approve visitor vehicle access requests</p>
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
            $pendingCount = $requests->where('status', 'pending')->count();
            $approvedCount = $requests->where('status', 'approved')->count();
            $rejectedCount = $requests->where('status', 'rejected')->count();
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

    <!-- Guest Access Requests List -->
    <div class="space-y-3">
        @forelse ($requests as $request)
            <!-- Minimized Card -->
            <div wire:click="openDetailModal({{ $request->id }})" class="bg-white dark:bg-zinc-800 border border-purple-200 dark:border-purple-700 rounded-xl p-4 shadow-sm hover:shadow-md transition-all cursor-pointer hover:border-purple-400 dark:hover:border-purple-500">
                <div class="flex justify-between items-center">
                    <div class="flex items-center gap-4 flex-1">
                        <span class="inline-block px-3 py-1 bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 text-xs font-bold rounded-full">🚗 GUEST ACCESS</span>
                        <div class="flex-1 grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                            <div>
                                <p class="text-zinc-500 dark:text-zinc-400 text-xs">Guest Name</p>
                                <p class="font-semibold text-zinc-900 dark:text-zinc-100">{{ $request->requested_changes['guest_name'] ?? 'Guest' }}</p>
                            </div>
                            <div>
                                <p class="text-zinc-500 dark:text-zinc-400 text-xs">Host/Resident</p>
                                <p class="font-medium text-zinc-900 dark:text-zinc-100">{{ $request->resident->name }}</p>
                            </div>
                            <div>
                                <p class="text-zinc-500 dark:text-zinc-400 text-xs">Vehicle Plate</p>
                                <p class="font-mono text-zinc-900 dark:text-zinc-100">{{ $request->requested_changes['guest_plate_number'] ?? 'N/A' }}</p>
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
                <p class="text-lg">📭 No guest access requests found</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    <div class="bg-white dark:bg-zinc-800 rounded-xl p-6 border border-zinc-200 dark:border-zinc-700">
        {{ $requests->links() }}
    </div>

    <!-- Information & Features Section -->
    <div class="bg-purple-50 dark:bg-purple-900/20 border border-purple-200 dark:border-purple-700 rounded-xl p-6">
        <h3 class="text-lg font-semibold text-purple-900 dark:text-purple-100 mb-3">🚗 Guest Vehicle Access Requests</h3>
        <ul class="text-sm text-purple-800 dark:text-purple-300 space-y-2">
            <li>✓ Residents can request visitor vehicle access</li>
            <li>✓ Capture complete guest owner personal details</li>
            <li>✓ Record guest vehicle information (plate, model, color)</li>
            <li>✓ Set specific access dates and reasons</li>
            <li>✓ Admin reviews and approves/rejects requests</li>
            <li>✓ Automatic notifications sent to residents</li>
            <li>✓ Approved guests can pass through gate</li>
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
                                    <span class="inline-block px-3 py-1 bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 text-xs font-bold rounded-full">🚗 GUEST ACCESS</span>
                                    <h3 class="text-xl font-semibold text-zinc-900 dark:text-zinc-100">{{ $selectedRequest->requested_changes['guest_name'] ?? 'Guest' }}</h3>
                                </div>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                    <div>
                                        <p class="text-zinc-500 dark:text-zinc-400">Host/Resident</p>
                                        <p class="font-medium text-zinc-900 dark:text-zinc-100">{{ $selectedRequest->resident->name }}</p>
                                    </div>
                                    <div>
                                        <p class="text-zinc-500 dark:text-zinc-400">Guest Vehicle Plate</p>
                                        <p class="font-mono text-zinc-900 dark:text-zinc-100">{{ $selectedRequest->requested_changes['guest_plate_number'] ?? 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-zinc-500 dark:text-zinc-400">Access Date</p>
                                        <p class="text-zinc-900 dark:text-zinc-100">{{ \Carbon\Carbon::parse($selectedRequest->requested_changes['access_date'] ?? '')->format('M d, Y') ?? 'N/A' }}</p>
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

                        <!-- Guest Information -->
                        <div class="mb-6 pb-4 border-b border-zinc-200 dark:border-zinc-700">
                            <h4 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100 mb-3">👥 Guest Information</h4>
                            <div class="bg-purple-50 dark:bg-purple-900/20 rounded-lg p-4">
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                    <div class="border border-purple-200 dark:border-purple-600 rounded p-3">
                                        <p class="text-xs font-semibold text-purple-600 dark:text-purple-400 uppercase mb-1">Guest Name</p>
                                        <p class="text-sm text-zinc-900 dark:text-zinc-100">{{ $selectedRequest->requested_changes['guest_name'] ?? 'N/A' }}</p>
                                    </div>
                                    <div class="border border-purple-200 dark:border-purple-600 rounded p-3">
                                        <p class="text-xs font-semibold text-purple-600 dark:text-purple-400 uppercase mb-1">Guest Age</p>
                                        <p class="text-sm text-zinc-900 dark:text-zinc-100">{{ $selectedRequest->requested_changes['guest_age'] ?? 'Not specified' }}</p>
                                    </div>
                                    <div class="border border-purple-200 dark:border-purple-600 rounded p-3">
                                        <p class="text-xs font-semibold text-purple-600 dark:text-purple-400 uppercase mb-1">Guest Contact</p>
                                        <p class="text-sm text-zinc-900 dark:text-zinc-100">{{ $selectedRequest->requested_changes['guest_contact_number'] ?? 'N/A' }}</p>
                                    </div>
                                    <div class="border border-purple-200 dark:border-purple-600 rounded p-3">
                                        <p class="text-xs font-semibold text-purple-600 dark:text-purple-400 uppercase mb-1">Guest Address</p>
                                        <p class="text-sm text-zinc-900 dark:text-zinc-100 break-words">{{ $selectedRequest->requested_changes['guest_address'] ?? 'Not specified' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Vehicle Information -->
                        <div class="mb-6 pb-4 border-b border-zinc-200 dark:border-zinc-700">
                            <h4 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100 mb-3">🚗 Vehicle Information</h4>
                            <div class="bg-purple-50 dark:bg-purple-900/20 rounded-lg p-4">
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="border border-purple-200 dark:border-purple-600 rounded p-3">
                                        <p class="text-xs font-semibold text-purple-600 dark:text-purple-400 uppercase mb-1">Vehicle Plate</p>
                                        <p class="text-sm font-mono text-zinc-900 dark:text-zinc-100">{{ $selectedRequest->requested_changes['guest_plate_number'] ?? 'N/A' }}</p>
                                    </div>
                                    <div class="border border-purple-200 dark:border-purple-600 rounded p-3">
                                        <p class="text-xs font-semibold text-purple-600 dark:text-purple-400 uppercase mb-1">Car Model</p>
                                        <p class="text-sm text-zinc-900 dark:text-zinc-100">{{ $selectedRequest->requested_changes['guest_car_model'] ?? 'N/A' }}</p>
                                    </div>
                                    <div class="border border-purple-200 dark:border-purple-600 rounded p-3">
                                        <p class="text-xs font-semibold text-purple-600 dark:text-purple-400 uppercase mb-1">Car Color</p>
                                        <p class="text-sm text-zinc-900 dark:text-zinc-100">{{ $selectedRequest->requested_changes['guest_car_color'] ?? 'Not specified' }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Access Reason -->
                        <div class="mb-6 pb-4 border-b border-zinc-200 dark:border-zinc-700">
                            <h4 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100 mb-2">📝 Reason for Access</h4>
                            <div class="bg-purple-50 dark:bg-purple-900/20 border border-purple-200 dark:border-purple-600 rounded-lg p-4">
                                <p class="text-sm text-zinc-900 dark:text-zinc-100">{{ $selectedRequest->requested_changes['access_reason'] ?? 'N/A' }}</p>
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
        showToast('✓ Approved', 'Guest access request has been approved.', 'success');
    });

    Livewire.on('rejectRequest', (requestId) => {
        showToast('✕ Rejected', 'Guest access request has been rejected.', 'success');
    });
</script>
