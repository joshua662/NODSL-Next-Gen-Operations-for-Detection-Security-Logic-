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

        <!-- Submit New Request Button -->
        <div class="mb-6">
            <a href="{{ route('resident.profile.edit') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10.5 1.5H19a1 1 0 011 1v16a1 1 0 01-1 1H1a1 1 0 01-1-1V2.5a1 1 0 011-1h9m0 0V1a1 1 0 112 0v.5m0 0a1 1 0 112 0"/>
                </svg>
                Submit New Request
            </a>
        </div>

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
                                @endphp
                                @if($changes)
                                    @foreach($changes as $field => $value)
                                        <div class="border border-zinc-200 dark:border-zinc-700 p-3 rounded">
                                            <p class="text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase mb-1">
                                                {{ str_replace('_', ' ', $field) }}
                                            </p>
                                            <p class="text-sm text-zinc-900 dark:text-zinc-100 break-words">
                                                {{ $value ?? '-' }}
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
                            <div class="mt-4 pt-4 border-t border-zinc-200 dark:border-zinc-700">
                                <a href="{{ route('resident.profile.edit') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.829.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                    </svg>
                                    Try Again
                                </a>
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
        <div class="mt-8 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
            <h3 class="text-sm font-semibold text-blue-900 dark:text-blue-200 mb-2">ℹ️ How It Works</h3>
            <ol class="text-sm text-blue-800 dark:text-blue-300 space-y-1 list-decimal list-inside">
                <li>Click "Submit New Request" to edit your profile</li>
                <li>Make the desired changes (name, contact, vehicle info, etc.)</li>
                <li>Submit your changes for admin review</li>
                <li>Track the approval status here</li>
                <li>Once approved, your changes will be active in the system</li>
            </ol>
        </div>
    </div>
</x-layouts.app>
