<x-layouts.app :title="__('Update Requests')">
    <style>
        [x-cloak] { display: none !important; }
    </style>
    <div class="flex h-full w-full flex-1 flex-col gap-4">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-zinc-900 dark:text-zinc-100">📤 Update Requests</h1>
            <p class="text-zinc-600 dark:text-zinc-400 mt-1">Submit and track your profile change requests</p>
        </div>

        @php
            $updateRequests = auth()->user()->resident->updateRequests()->latest()->paginate(10);
        @endphp

        <!-- Profile Update Card Section -->
        <div class="mb-6">
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/30 dark:to-blue-900/50 border-2 border-blue-200 dark:border-blue-700 rounded-xl p-6 w-full">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h3 class="text-xl font-bold text-blue-900 dark:text-blue-100">📝 Update Profile</h3>
                        <p class="text-sm text-blue-800 dark:text-blue-300 mt-1">Modify your personal information</p>
                    </div>
                    <span class="inline-block px-3 py-1 bg-blue-200 dark:bg-blue-800 text-blue-900 dark:text-blue-100 text-xs font-bold rounded-full">Personal</span>
                </div>
                
                <ul class="text-sm text-blue-800 dark:text-blue-300 space-y-2 mb-6">
                    <li>✓ Update name or contact information</li>
                    <li>✓ Change vehicle details</li>
                    <li>✓ Modify residential address</li>
                    <li>✓ Requires admin approval</li>
                </ul>
                
                <a href="{{ route('resident.profile.edit') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition w-full justify-center">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.5 1.5H19a1 1 0 011 1v16a1 1 0 01-1 1H1a1 1 0 01-1-1V2.5a1 1 0 011-1h9m0 0V1a1 1 0 112 0v.5m0 0a1 1 0 112 0"/>
                    </svg>
                    Submit Profile Update
                </a>
            </div>
        </div>

        <!-- Submit New Request Button -->

        <!-- Summary Stats -->
        <div class="grid gap-4 md:grid-cols-4 mb-6">
            <div class="border border-zinc-200 dark:border-zinc-700 rounded-xl p-4 bg-zinc-50 dark:bg-zinc-900">
                <p class="text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase mb-1">Total Requests</p>
                <p class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">{{ auth()->user()->resident->updateRequests()->count() }}</p>
            </div>
            <div class="border border-zinc-200 dark:border-zinc-700 rounded-xl p-4 bg-yellow-50 dark:bg-yellow-900/20">
                <p class="text-xs font-semibold text-yellow-600 dark:text-yellow-400 uppercase mb-1">Pending</p>
                <p class="text-2xl font-bold text-yellow-700 dark:text-yellow-400">{{ auth()->user()->resident->updateRequests()->where('status', 'pending')->count() }}</p>
            </div>
            <div class="border border-zinc-200 dark:border-zinc-700 rounded-xl p-4 bg-green-50 dark:bg-green-900/20">
                <p class="text-xs font-semibold text-green-600 dark:text-green-400 uppercase mb-1">Approved</p>
                <p class="text-2xl font-bold text-green-700 dark:text-green-400">{{ auth()->user()->resident->updateRequests()->where('status', 'approved')->count() }}</p>
            </div>
            <div class="border border-zinc-200 dark:border-zinc-700 rounded-xl p-4 bg-red-50 dark:bg-red-900/20">
                <p class="text-xs font-semibold text-red-600 dark:text-red-400 uppercase mb-1">Rejected</p>
                <p class="text-2xl font-bold text-red-700 dark:text-red-400">{{ auth()->user()->resident->updateRequests()->where('status', 'rejected')->count() }}</p>
            </div>
        </div>

        <!-- Update Requests List -->
        <div class="space-y-3" x-data="{ openModal: null }">
            @if($updateRequests->count() > 0)
                @foreach($updateRequests as $request)
                    <!-- Minimized Card -->
                    <div @click="openModal = {{ $request->id }}" class="border border-zinc-200 dark:border-zinc-700 rounded-xl p-4 bg-white dark:bg-zinc-800 cursor-pointer hover:shadow-md hover:border-blue-400 dark:hover:border-blue-500 transition-all">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center gap-4 flex-1">
                                <span class="inline-block px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 text-xs font-bold rounded-full">📝 PROFILE UPDATE</span>
                                <div class="flex-1 grid grid-cols-2 md:grid-cols-3 gap-4 text-sm">
                                    <div>
                                        <p class="text-zinc-500 dark:text-zinc-400 text-xs">Request #{{ $request->id }}</p>
                                        <p class="font-semibold text-zinc-900 dark:text-zinc-100">Profile Update</p>
                                    </div>
                                    <div>
                                        <p class="text-zinc-500 dark:text-zinc-400 text-xs">Submitted</p>
                                        <p class="text-zinc-900 dark:text-zinc-100">{{ $request->created_at->format('M d, Y g:i A') }}</p>
                                    </div>
                                    <div>
                                        <p class="text-zinc-500 dark:text-zinc-400 text-xs">Changes</p>
                                        <p class="text-zinc-900 dark:text-zinc-100">{{ count(is_array($request->requested_changes) ? $request->requested_changes : json_decode($request->requested_changes, true)) }} field(s)</p>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 ml-4">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full
                                    @if($request->status === 'pending')
                                        bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400
                                    @elseif($request->status === 'approved')
                                        bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400
                                    @else
                                        bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400
                                    @endif">
                                    {{ strtoupper($request->status) }}
                                </span>
                                <svg class="w-5 h-5 text-zinc-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Detail Modal -->
                    <div x-show="openModal === {{ $request->id }}" x-cloak @click.away="openModal = null" class="fixed inset-0 z-50 overflow-y-auto">
                        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:p-0">
                            <div class="fixed inset-0 bg-white/80 dark:bg-zinc-900/80 backdrop-blur-sm transition-opacity" @click="openModal = null"></div>
                            <div class="relative inline-block align-middle bg-white dark:bg-zinc-800 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:max-w-4xl sm:w-full" @click.stop>
                                <div class="px-8 pt-6 pb-6">
                                    <!-- Header -->
                                    <div class="flex justify-between items-start mb-6 pb-4 border-b border-zinc-200 dark:border-zinc-700">
                                        <div class="flex-1">
                                            <div class="flex items-center gap-3 mb-3">
                                                <h3 class="text-xl font-semibold text-zinc-900 dark:text-zinc-100">
                                                    Profile Update Request #{{ $request->id }}
                                                </h3>
                                                <span class="px-3 py-1 text-xs font-semibold rounded-full
                                                    @if($request->status === 'pending')
                                                        bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400
                                                    @elseif($request->status === 'approved')
                                                        bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400
                                                    @else
                                                        bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400
                                                    @endif">
                                                    {{ strtoupper($request->status) }}
                                                </span>
                                            </div>
                                            <p class="text-sm text-zinc-600 dark:text-zinc-400">
                                                Submitted on {{ $request->created_at->format('M d, Y \a\t H:i') }}
                                            </p>
                                        </div>
                                        <button @click="openModal = null" class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>

                                    <!-- Requested Changes -->
                                    <div class="bg-zinc-50 dark:bg-zinc-900 rounded-lg p-4 mb-4">
                                        <h4 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100 mb-3">Requested Changes:</h4>
                                        <div class="grid gap-3 md:grid-cols-2">
                                            @php
                                                $changes = is_array($request->requested_changes) ? $request->requested_changes : json_decode($request->requested_changes, true);
                                                $displayChanges = array_filter($changes, function($key) {
                                                    $excludeFields = ['request_type', 'guest_name', 'guest_age', 'guest_contact_number', 'guest_address', 'guest_plate_number', 'guest_car_model', 'guest_car_color', 'access_date', 'access_reason'];
                                                    return !in_array($key, $excludeFields);
                                                }, ARRAY_FILTER_USE_KEY);
                                            @endphp
                                            @if($displayChanges)
                                                @foreach($displayChanges as $field => $value)
                                                    <div class="border border-zinc-200 dark:border-zinc-700 p-3 rounded">
                                                        <p class="text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase mb-1">
                                                            {{ str_replace('_', ' ', $field) }}
                                                        </p>
                                                        <p class="text-sm text-zinc-900 dark:text-zinc-100 break-words">
                                                            @if($field === 'is_personal_data_request' && $value)
                                                                <span class="inline-block px-2 py-1 bg-blue-200 dark:bg-blue-800 text-blue-900 dark:text-blue-100 text-xs rounded">🔐 Access to Other Owner's Personal Data</span>
                                                            @else
                                                                {{ $value ?? '-' }}
                                                            @endif
                                                        </p>
                                                    </div>
                                                @endforeach
                                            @else
                                                <p class="text-sm text-zinc-500 dark:text-zinc-400">No changes recorded</p>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Admin Comments (if rejected) -->
                                    @if($request->status === 'rejected' && $request->reason)
                                        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4 mb-4">
                                            <h4 class="text-sm font-semibold text-red-900 dark:text-red-200 mb-2">⚠ Rejection Reason:</h4>
                                            <p class="text-sm text-red-800 dark:text-red-300">{{ $request->reason }}</p>
                                        </div>
                                    @endif

                                    <!-- Status Timeline -->
                                    <div class="border-t border-zinc-200 dark:border-zinc-700 pt-4">
                                        <h4 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100 mb-3">Status Timeline:</h4>
                                        <div class="space-y-2">
                                            <div class="flex items-center gap-3">
                                                <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                                                <p class="text-sm text-zinc-700 dark:text-zinc-300">
                                                    <strong>Submitted:</strong> {{ $request->created_at->format('M d, Y H:i') }}
                                                </p>
                                            </div>
                                            @if($request->status === 'approved')
                                                <div class="flex items-center gap-3">
                                                    <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                                    <p class="text-sm text-green-700 dark:text-green-400">
                                                        <strong>Approved:</strong> {{ $request->updated_at->format('M d, Y H:i') }}
                                                    </p>
                                                </div>
                                            @elseif($request->status === 'rejected')
                                                <div class="flex items-center gap-3">
                                                    <div class="w-3 h-3 bg-red-500 rounded-full"></div>
                                                    <p class="text-sm text-red-700 dark:text-red-400">
                                                        <strong>Rejected:</strong> {{ $request->updated_at->format('M d, Y H:i') }}
                                                    </p>
                                                </div>
                                            @else
                                                <div class="flex items-center gap-3">
                                                    <div class="w-3 h-3 bg-yellow-500 rounded-full animate-pulse"></div>
                                                    <p class="text-sm text-yellow-700 dark:text-yellow-400">
                                                        <strong>Pending:</strong> Awaiting admin review...
                                                    </p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    @if($request->status === 'rejected')
                                        <div class="mt-4 pt-4 border-t border-zinc-200 dark:border-zinc-700 flex gap-3">
                                            <a href="{{ route('resident.profile.edit') }}" class="flex-1 inline-flex items-center justify-center gap-2 px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-semibold transition shadow-sm hover:shadow-md">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.829.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                                </svg>
                                                Edit & Resubmit
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Pagination -->
                <div class="pt-6">
                    {{ $updateRequests->links() }}
                </div>
            @else
                <div class="text-center py-12 border border-zinc-200 dark:border-zinc-700 rounded-xl">
                    <p class="text-zinc-500 dark:text-zinc-400 text-lg">📋 No update requests yet</p>
                    <p class="text-zinc-500 dark:text-zinc-400 text-sm mt-2">Submit your first profile update request to get started</p>
                    <a href="{{ route('resident.profile.edit') }}" class="inline-flex items-center gap-2 mt-4 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                        </svg>
                        Submit Request
                    </a>
                </div>
            @endif
        </div>

        <!-- Help Section -->
        <div class="mt-8">
            <div class="p-6 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg w-full">
                <h3 class="text-lg font-semibold text-blue-900 dark:text-blue-200 mb-3">📝 Profile Update Guide</h3>
                <ol class="text-sm text-blue-800 dark:text-blue-300 space-y-2 list-decimal list-inside">
                    <li>Click "Submit Profile Update" button</li>
                    <li>Edit your personal or vehicle information</li>
                    <li>Submit changes for admin review</li>
                    <li>Wait for approval notification</li>
                    <li>Changes become active once approved</li>
                </ol>
            </div>
        </div>
    </div>
</x-layouts.app>
