<x-layouts.app :title="__('Update Requests')">
    <div class="flex h-full w-full flex-1 flex-col gap-4">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-zinc-900 dark:text-zinc-100">📤 Update Requests</h1>
            <p class="text-zinc-600 dark:text-zinc-400 mt-1">Submit and track your profile change requests</p>
        </div>

        @php
            $updateRequests = auth()->user()->resident->updateRequests()->latest()->paginate(10);
        @endphp

        <!-- Two Action Cards Section -->
        <div class="grid md:grid-cols-2 gap-6 mb-6">
            <!-- Profile Update Card -->
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/30 dark:to-blue-900/50 border-2 border-blue-200 dark:border-blue-700 rounded-xl p-6">
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

            <!-- Guest Access Card -->
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 dark:from-purple-900/30 dark:to-purple-900/50 border-2 border-purple-200 dark:border-purple-700 rounded-xl p-6">
                <div class="flex items-start justify-between mb-4">
                    <div>
                        <h3 class="text-xl font-bold text-purple-900 dark:text-purple-100">🚗 Request Guest Access</h3>
                        <p class="text-sm text-purple-800 dark:text-purple-300 mt-1">Allow visitor vehicles to enter</p>
                    </div>
                    <span class="inline-block px-3 py-1 bg-purple-200 dark:bg-purple-800 text-purple-900 dark:text-purple-100 text-xs font-bold rounded-full">Visitor</span>
                </div>
                
                <ul class="text-sm text-purple-800 dark:text-purple-300 space-y-2 mb-6">
                    <li>✓ Allow guest vehicles to pass gate</li>
                    <li>✓ Capture visitor vehicle info</li>
                    <li>✓ Set specific access dates</li>
                    <li>✓ Requires admin approval</li>
                </ul>
                
                <a href="{{ route('resident.guest-access.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white rounded-lg font-medium transition w-full justify-center">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                        <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z"/>
                    </svg>
                    Request Guest Access
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
        <div class="space-y-4">
            @if($updateRequests->count() > 0)
                @foreach($updateRequests as $request)
                    <div class="border border-zinc-200 dark:border-zinc-700 rounded-xl p-6 bg-white dark:bg-zinc-800">
                        <div class="flex items-start justify-between gap-4 mb-4">
                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2">
                                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">
                                        Profile Update Request #{{ $request->id }}
                                    </h3>
                                    <span class="inline-block px-3 py-1 text-xs font-semibold rounded-full
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
                        </div>

                        <!-- Requested Changes -->
                        <div class="bg-zinc-50 dark:bg-zinc-900 rounded-lg p-4 mb-4">
                            <h4 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100 mb-3">Requested Changes:</h4>
                            <div class="grid gap-3 md:grid-cols-2">
                                @php
                                    $changes = is_array($request->requested_changes) ? $request->requested_changes : json_decode($request->requested_changes, true);
                                    // Filter out guest access fields and metadata
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
                        @if($request->status === 'rejected' && $request->admin_remarks)
                            <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-4 mb-4">
                                <h4 class="text-sm font-semibold text-red-900 dark:text-red-200 mb-2">⚠ Rejection Reason:</h4>
                                <p class="text-sm text-red-800 dark:text-red-300">{{ $request->admin_remarks }}</p>
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
                                <button class="flex items-center justify-center gap-2 px-4 py-3 bg-red-100 hover:bg-red-200 dark:bg-red-900/30 hover:dark:bg-red-900/50 text-red-700 dark:text-red-400 rounded-lg text-sm font-semibold transition" title="Delete request">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                </button>
                            </div>
                        @elseif($request->status === 'pending')
                            <div class="mt-4 pt-4 border-t border-zinc-200 dark:border-zinc-700 flex justify-end">
                                <button class="flex items-center justify-center gap-2 px-4 py-3 bg-red-100 hover:bg-red-200 dark:bg-red-900/30 hover:dark:bg-red-900/50 text-red-700 dark:text-red-400 rounded-lg text-sm font-semibold transition" title="Delete request">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                </button>
                            </div>
                        @endif
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
        <div class="mt-8 grid md:grid-cols-2 gap-6">
            <!-- Profile Update Help -->
            <div class="p-6 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                <h3 class="text-lg font-semibold text-blue-900 dark:text-blue-200 mb-3">📝 Profile Update Guide</h3>
                <ol class="text-sm text-blue-800 dark:text-blue-300 space-y-2 list-decimal list-inside">
                    <li>Click "Submit Profile Update" button</li>
                    <li>Edit your personal or vehicle information</li>
                    <li>Submit changes for admin review</li>
                    <li>Wait for approval notification</li>
                    <li>Changes become active once approved</li>
                </ol>
            </div>

            <!-- Guest Access Help -->
            <div class="p-6 bg-purple-50 dark:bg-purple-900/20 border border-purple-200 dark:border-purple-800 rounded-lg">
                <h3 class="text-lg font-semibold text-purple-900 dark:text-purple-200 mb-3">🚗 Guest Access Guide</h3>
                <ol class="text-sm text-purple-800 dark:text-purple-300 space-y-2 list-decimal list-inside">
                    <li>Click "Request Guest Access" button</li>
                    <li>Fill in guest vehicle owner details</li>
                    <li>Enter guest vehicle information</li>
                    <li>Set access date and reason</li>
                    <li>Submit for admin approval</li>
                </ol>
            </div>
        </div>
    </div>
</x-layouts.app>
