<x-layouts.app :title="__('Request Guest Access')">
    <style>
        [x-cloak] { display: none !important; }
    </style>
    <div class="flex h-full w-full flex-1 flex-col gap-6">
        <!-- Header Section -->
        <div class="mb-4">
            <h1 class="text-3xl font-bold text-zinc-900 dark:text-zinc-100">🚗 Request Guest Access</h1>
            <p class="text-zinc-600 dark:text-zinc-400 mt-1">Allow visitor vehicles to enter the subdivision</p>
        </div>

        <!-- Main Content Container -->
        <div class="w-full">
            <form action="{{ route('resident.guest-access.store') ?? '#' }}" method="POST" class="border border-zinc-200 dark:border-zinc-700 rounded-xl p-8 bg-white dark:bg-zinc-800 space-y-6 shadow-sm">
                @csrf

                <!-- Host Information (Auto-filled) -->
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                    <h3 class="text-lg font-semibold text-blue-900 dark:text-blue-100 mb-3">👤 Your Information (Host)</h3>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-xs font-semibold text-blue-700 dark:text-blue-300 uppercase mb-1">Host Name</p>
                            <p class="text-sm font-medium text-blue-900 dark:text-blue-100">{{ auth()->user()->resident->name }}</p>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-blue-700 dark:text-blue-300 uppercase mb-1">Your Vehicle Plate</p>
                            <p class="text-sm font-medium text-blue-900 dark:text-blue-100">{{ auth()->user()->resident->plate_number }}</p>
                        </div>
                    </div>
                </div>

                <hr class="border-zinc-200 dark:border-zinc-700">

                <!-- Guest Information -->
                <div>
                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100 mb-4">👥 Guest Vehicle Owner Information</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Guest Name -->
                        <div>
                        <label for="guest_name" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Guest Name *</label>
                        <input type="text" id="guest_name" name="guest_name" value="{{ old('guest_name') }}" required 
                            placeholder="Full name of the guest vehicle owner"
                            class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-zinc-100 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition @error('guest_name') border-red-500 @enderror">
                        @error('guest_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Guest Age -->
                        <div>
                        <label for="guest_age" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Guest Age</label>
                        <input type="number" id="guest_age" name="guest_age" value="{{ old('guest_age') }}" min="1" max="150"
                            placeholder="Age (optional)"
                            class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-zinc-100 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition @error('guest_age') border-red-500 @enderror">
                        @error('guest_age')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Guest Contact Number -->
                        <div>
                        <label for="guest_contact_number" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Guest Contact Number *</label>
                        <input type="tel" id="guest_contact_number" name="guest_contact_number" value="{{ old('guest_contact_number') }}" required
                            placeholder="Mobile number of the guest"
                            class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-zinc-100 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition @error('guest_contact_number') border-red-500 @enderror">
                        @error('guest_contact_number')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Guest Address -->
                        <div>
                        <label for="guest_address" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Guest Address</label>
                        <textarea id="guest_address" name="guest_address" rows="2"
                            placeholder="Home address of the guest (optional)"
                            class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-zinc-100 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition @error('guest_address') border-red-500 @enderror">{{ old('guest_address') }}</textarea>
                        @error('guest_address')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        </div>
                    </div>
                </div>

                <hr class="border-zinc-200 dark:border-zinc-700">

                <!-- Guest Vehicle Information -->
                <div>
                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100 mb-4">🚗 Guest Vehicle Information</h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Guest Plate Number -->
                        <div>
                        <label for="guest_plate_number" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Vehicle Plate Number *</label>
                        <input type="text" id="guest_plate_number" name="guest_plate_number" value="{{ old('guest_plate_number') }}" required
                            placeholder="e.g., ABC-1234"
                            class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-zinc-100 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition uppercase font-mono @error('guest_plate_number') border-red-500 @enderror">
                        @error('guest_plate_number')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Guest Car Model -->
                        <div>
                        <label for="guest_car_model" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Car Model *</label>
                        <input type="text" id="guest_car_model" name="guest_car_model" value="{{ old('guest_car_model') }}" required
                            placeholder="e.g., Honda Civic 2020"
                            class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-zinc-100 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition @error('guest_car_model') border-red-500 @enderror">
                        @error('guest_car_model')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Guest Car Color -->
                        <div>
                        <label for="guest_car_color" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Car Color</label>
                        <input type="text" id="guest_car_color" name="guest_car_color" value="{{ old('guest_car_color') }}"
                            placeholder="e.g., White"
                            class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-zinc-100 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition @error('guest_car_color') border-red-500 @enderror">
                        @error('guest_car_color')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        </div>
                    </div>
                </div>

                <hr class="border-zinc-200 dark:border-zinc-700">

                <!-- Access Details -->
                <div>
                    <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100 mb-4">📅 Access Details</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Access Date -->
                        <div>
                        <label for="access_date" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Access Date *</label>
                        <input type="date" id="access_date" name="access_date" value="{{ old('access_date') }}" required
                            class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-zinc-100 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition @error('access_date') border-red-500 @enderror">
                        @error('access_date')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Access Reason -->
                        <div>
                        <label for="access_reason" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Reason for Access *</label>
                        <textarea id="access_reason" name="access_reason" rows="3" required
                                placeholder="Why is this guest vehicle allowed to enter? (e.g., Family visit, delivery, service provider, etc.)"
                            class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-zinc-100 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition @error('access_reason') border-red-500 @enderror">{{ old('access_reason') }}</textarea>
                        @error('access_reason')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                        </div>
                    </div>
                </div>

                <hr class="border-zinc-200 dark:border-zinc-700">

                <!-- Info Alert -->
                <div class="bg-purple-50 dark:bg-purple-900/20 border border-purple-200 dark:border-purple-800 rounded-lg p-4">
                    <p class="text-sm text-purple-900 dark:text-purple-200">
                        <strong>ℹ️ Note:</strong> Your guest access request will be submitted for admin review. Once approved, the guest vehicle will be able to pass through the gate. You will receive a notification once the request is processed.
                    </p>
                </div>

                <!-- Form Actions -->
                <div class="flex gap-3 pt-6 border-t border-zinc-200 dark:border-zinc-700">
                    <button type="submit" class="flex-1 inline-flex items-center justify-center gap-2 px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white rounded-lg font-semibold transition shadow-md hover:shadow-lg">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Submit Guest Access Request
                    </button>
                    <a href="{{ route('resident.update-requests') }}" class="px-6 py-3 border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-700 rounded-lg font-medium transition">
                        Cancel
                    </a>
                </div>
            </form>
        </div>

        <!-- Guest Access Request History -->
        <div class="w-full mt-8">
            <div class="mb-6">
                <h2 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100 mb-2">📋 Your Guest Access Requests</h2>
                <p class="text-sm text-zinc-600 dark:text-zinc-400">Track the status of your submitted guest access requests</p>
            </div>
            
            @php
                $guestAccessRequests = auth()->user()->resident->updateRequests()
                    ->where(function($q) {
                        $q->whereJsonContains('requested_changes->request_type', 'guest_access');
                    })
                    ->orderBy('created_at', 'desc')
                    ->get();
            @endphp

            <div x-data="{ openModal: null }" class="space-y-3">
            @forelse($guestAccessRequests as $request)
                    <!-- Minimized Card -->
                    <div @click="openModal = {{ $request->id }}" class="border border-purple-200 dark:border-purple-700 rounded-xl p-4 bg-white dark:bg-zinc-800 shadow-sm cursor-pointer hover:shadow-md hover:border-purple-400 dark:hover:border-purple-500 transition-all">
                        <div class="flex justify-between items-center">
                            <div class="flex items-center gap-4 flex-1">
                                <span class="inline-block px-3 py-1 bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 text-xs font-bold rounded-full">🚗 GUEST ACCESS</span>
                                <div class="flex-1 grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                    <div>
                                        <p class="text-zinc-500 dark:text-zinc-400 text-xs">Request #{{ $request->id }}</p>
                                        <p class="font-semibold text-zinc-900 dark:text-zinc-100">{{ $request->requested_changes['guest_name'] ?? 'Guest' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-zinc-500 dark:text-zinc-400 text-xs">Vehicle Plate</p>
                                        <p class="font-mono text-zinc-900 dark:text-zinc-100">{{ $request->requested_changes['guest_plate_number'] ?? 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-zinc-500 dark:text-zinc-400 text-xs">Access Date</p>
                                        <p class="text-zinc-900 dark:text-zinc-100">{{ \Carbon\Carbon::parse($request->requested_changes['access_date'] ?? '')->format('M d, Y') ?? 'N/A' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-zinc-500 dark:text-zinc-400 text-xs">Submitted</p>
                                        <p class="text-zinc-900 dark:text-zinc-100">{{ $request->created_at->format('M d, Y g:i A') }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="flex items-center gap-3 ml-4">
                                <span class="px-3 py-1 text-xs font-semibold rounded-full whitespace-nowrap
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
                                                <span class="inline-block px-3 py-1 bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 text-xs font-bold rounded-full">🚗 GUEST ACCESS</span>
                                                <h3 class="text-xl font-semibold text-zinc-900 dark:text-zinc-100">
                                                    Guest Access Request #{{ $request->id }}
                                                </h3>
                                                <span class="px-3 py-1 text-xs font-semibold rounded-full whitespace-nowrap
                                                    {{ $request->status === 'approved' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-200' : 
                                                       ($request->status === 'rejected' ? 'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-200' : 
                                                       'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-200') }}">
                                                    {{ ucfirst($request->status) }}
                                                </span>
                                            </div>
                                            <p class="text-sm text-zinc-500 dark:text-zinc-400">
                                                Submitted on {{ $request->created_at->format('M d, Y \a\t h:i A') }}
                                            </p>
                                        </div>
                                        <button @click="openModal = null" class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </button>
                                    </div>

                                    <!-- Request Details -->
                                    <div class="space-y-4">
                                        <div>
                                            <h4 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100 mb-3">👥 Guest Information</h4>
                                            <div class="grid md:grid-cols-2 gap-3">
                                                <div class="bg-zinc-50 dark:bg-zinc-700/50 rounded p-3">
                                                    <p class="text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase mb-1">Guest Name</p>
                                                    <p class="text-sm text-zinc-900 dark:text-zinc-100">{{ $request->requested_changes['guest_name'] ?? 'N/A' }}</p>
                                                </div>
                                                <div class="bg-zinc-50 dark:bg-zinc-700/50 rounded p-3">
                                                    <p class="text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase mb-1">Guest Age</p>
                                                    <p class="text-sm text-zinc-900 dark:text-zinc-100">{{ $request->requested_changes['guest_age'] ?? 'Not specified' }}</p>
                                                </div>
                                                <div class="bg-zinc-50 dark:bg-zinc-700/50 rounded p-3">
                                                    <p class="text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase mb-1">Contact Number</p>
                                                    <p class="text-sm text-zinc-900 dark:text-zinc-100">{{ $request->requested_changes['guest_contact_number'] ?? 'N/A' }}</p>
                                                </div>
                                                <div class="bg-zinc-50 dark:bg-zinc-700/50 rounded p-3">
                                                    <p class="text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase mb-1">Address</p>
                                                    <p class="text-sm text-zinc-900 dark:text-zinc-100">{{ $request->requested_changes['guest_address'] ?? 'Not specified' }}</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div>
                                            <h4 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100 mb-3">🚗 Vehicle Information</h4>
                                            <div class="grid md:grid-cols-2 gap-3">
                                                <div class="bg-zinc-50 dark:bg-zinc-700/50 rounded p-3">
                                                    <p class="text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase mb-1">Plate Number</p>
                                                    <p class="text-sm font-mono text-zinc-900 dark:text-zinc-100">{{ $request->requested_changes['guest_plate_number'] ?? 'N/A' }}</p>
                                                </div>
                                                <div class="bg-zinc-50 dark:bg-zinc-700/50 rounded p-3">
                                                    <p class="text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase mb-1">Car Model</p>
                                                    <p class="text-sm text-zinc-900 dark:text-zinc-100">{{ $request->requested_changes['guest_car_model'] ?? 'N/A' }}</p>
                                                </div>
                                                <div class="bg-zinc-50 dark:bg-zinc-700/50 rounded p-3">
                                                    <p class="text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase mb-1">Car Color</p>
                                                    <p class="text-sm text-zinc-900 dark:text-zinc-100">{{ $request->requested_changes['guest_car_color'] ?? 'Not specified' }}</p>
                                                </div>
                                                <div class="bg-zinc-50 dark:bg-zinc-700/50 rounded p-3">
                                                    <p class="text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase mb-1">Access Date</p>
                                                    <p class="text-sm text-zinc-900 dark:text-zinc-100">{{ \Carbon\Carbon::parse($request->requested_changes['access_date'] ?? '')->format('M d, Y') ?? 'N/A' }}</p>
                                                </div>
                                            </div>
                                        </div>

                                        <div>
                                            <h4 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100 mb-2">📝 Reason for Access</h4>
                                            <div class="bg-purple-50 dark:bg-purple-900/20 border border-purple-200 dark:border-purple-700 rounded p-3">
                                                <p class="text-sm text-zinc-900 dark:text-zinc-100">{{ $request->requested_changes['access_reason'] ?? 'N/A' }}</p>
                                            </div>
                                        </div>

                                        <!-- Status Timeline -->
                                        <div class="pt-3 border-t border-zinc-200 dark:border-zinc-700">
                                            <h4 class="text-sm font-semibold text-zinc-900 dark:text-zinc-100 mb-3">📅 Status Timeline</h4>
                                            <div class="space-y-2">
                                                <div class="flex items-center gap-3">
                                                    <div class="w-3 h-3 rounded-full bg-blue-500"></div>
                                                    <p class="text-sm text-zinc-700 dark:text-zinc-300">
                                                        <strong>Submitted:</strong> {{ $request->created_at->format('M d, Y h:i A') }}
                                                    </p>
                                                </div>
                                                @if($request->reviewed_at)
                                                    <div class="flex items-center gap-3">
                                                        <div class="w-3 h-3 rounded-full {{ $request->status === 'approved' ? 'bg-green-500' : 'bg-red-500' }}"></div>
                                                        <p class="text-sm text-zinc-700 dark:text-zinc-300">
                                                            <strong>{{ ucfirst($request->status) }}:</strong> {{ $request->reviewed_at->format('M d, Y h:i A') }}
                                                        </p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                <div class="border border-zinc-200 dark:border-zinc-700 rounded-xl p-8 bg-white dark:bg-zinc-800 text-center">
                    <p class="text-zinc-500 dark:text-zinc-400">No guest access requests yet. Submit your first request above!</p>
                </div>
            @endforelse
        </div>
    </div>
</x-layouts.app>
