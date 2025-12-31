<x-layouts.app :title="__('My Profile')">
    <style>
        [x-cloak] { display: none !important; }
    </style>
    <div class="flex h-full w-full flex-1 flex-col gap-4" x-data="{ showEditModal: false }">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-zinc-900 dark:text-zinc-100">👤 My Profile</h1>
            <p class="text-zinc-600 dark:text-zinc-400 mt-1">View and manage your personal information</p>
        </div>

        @php
            $resident = auth()->user()->resident;
            $nameParts = explode(' ', $resident->name ?? '');
            $initials = strtoupper(substr($nameParts[0] ?? '', 0, 1) . substr($nameParts[1] ?? '', 0, 1));
        @endphp

        <!-- Profile Header Card -->
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 dark:from-blue-800 dark:to-blue-900 rounded-2xl p-8 mb-6 shadow-lg">
            <div class="flex items-center gap-6">
                <div class="relative">
                    <div class="w-24 h-24 rounded-full bg-white/20 backdrop-blur-sm flex items-center justify-center text-white text-3xl font-bold border-4 border-white/30">
                        {{ $initials ?: 'U' }}
                    </div>
                    <button class="absolute bottom-0 right-0 w-8 h-8 bg-white hover:bg-zinc-100 rounded-full flex items-center justify-center text-blue-600 shadow-lg transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                    </button>
                </div>
                <div class="flex-1">
                    <h2 class="text-3xl font-bold text-white mb-2">{{ $resident->name }}</h2>
                    <p class="text-blue-100 text-lg">Resident Member</p>
                    <div class="flex items-center gap-2 mt-3">
                        <div class="w-2 h-2 bg-green-300 rounded-full animate-pulse"></div>
                        <span class="text-white/90 text-sm">Active Account</span>
                    </div>
                </div>
                <button @click="showEditModal = true" class="px-6 py-3 bg-white hover:bg-zinc-50 text-blue-600 rounded-xl text-sm font-semibold transition shadow-lg hover:shadow-xl">
                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit Profile
                </button>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-3">
            <!-- Profile Card -->
            <div class="lg:col-span-2 border border-zinc-200 dark:border-zinc-700 rounded-2xl p-8 bg-white dark:bg-zinc-800 shadow-sm hover:shadow-md transition-shadow">
                <div class="flex items-center gap-3 mb-8">
                    <div class="w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">Personal Information</h2>
                </div>

                <div class="grid gap-6 md:grid-cols-2">
                    <!-- First Name -->
                    <div class="bg-zinc-50 dark:bg-zinc-900/50 rounded-xl p-4 border border-zinc-100 dark:border-zinc-700">
                        <label class="block text-xs font-semibold text-zinc-500 dark:text-zinc-400 uppercase mb-2">First Name</label>
                        <p class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">{{ explode(' ', $resident->name)[0] ?? $resident->name }}</p>
                    </div>

                    <!-- Last Name -->
                    <div class="bg-zinc-50 dark:bg-zinc-900/50 rounded-xl p-4 border border-zinc-100 dark:border-zinc-700">
                        <label class="block text-xs font-semibold text-zinc-500 dark:text-zinc-400 uppercase mb-2">Last Name</label>
                        <p class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">{{ implode(' ', array_slice(explode(' ', $resident->name), 1)) ?? '-' }}</p>
                    </div>

                    <!-- Age -->
                    <div class="bg-zinc-50 dark:bg-zinc-900/50 rounded-xl p-4 border border-zinc-100 dark:border-zinc-700">
                        <label class="block text-xs font-semibold text-zinc-500 dark:text-zinc-400 uppercase mb-2">Age</label>
                        <p class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">{{ $resident->age ?? '-' }}</p>
                    </div>

                    <!-- Contact Number -->
                    <div class="bg-zinc-50 dark:bg-zinc-900/50 rounded-xl p-4 border border-zinc-100 dark:border-zinc-700">
                        <label class="block text-xs font-semibold text-zinc-500 dark:text-zinc-400 uppercase mb-2">Contact Number</label>
                        <p class="text-lg font-semibold text-zinc-900 dark:text-zinc-100 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            {{ $resident->contact_number ?? '-' }}
                        </p>
                    </div>

                    <!-- Address -->
                    <div class="bg-zinc-50 dark:bg-zinc-900/50 rounded-xl p-4 border border-zinc-100 dark:border-zinc-700 md:col-span-2">
                        <label class="block text-xs font-semibold text-zinc-500 dark:text-zinc-400 uppercase mb-2">Address</label>
                        <p class="text-lg font-semibold text-zinc-900 dark:text-zinc-100 flex items-start gap-2">
                            <svg class="w-5 h-5 text-blue-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span>{{ $resident->address ?? '-' }}</span>
                        </p>
                    </div>
                </div>

                <div class="my-8 border-t border-zinc-200 dark:border-zinc-700 pt-8">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-lg bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1v-5a1 1 0 00-.293-.707l-2-2A1 1 0 0015 7h-1z" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-zinc-900 dark:text-zinc-100">Vehicle Information</h3>
                    </div>

                    <div class="grid gap-6 md:grid-cols-2">
                        <!-- Plate Number -->
                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-xl p-5 border-2 border-blue-200 dark:border-blue-800">
                            <label class="block text-xs font-semibold text-blue-600 dark:text-blue-400 uppercase mb-3">Plate Number</label>
                            <p class="text-2xl font-bold text-blue-900 dark:text-blue-100 font-mono tracking-wider">{{ $resident->plate_number ?? '-' }}</p>
                        </div>

                        <!-- Car Model -->
                        <div class="bg-zinc-50 dark:bg-zinc-900/50 rounded-xl p-5 border border-zinc-100 dark:border-zinc-700">
                            <label class="block text-xs font-semibold text-zinc-500 dark:text-zinc-400 uppercase mb-2">Car Model</label>
                            <p class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">{{ $resident->car_model ?? '-' }}</p>
                        </div>

                        <!-- Car Color -->
                        <div class="bg-zinc-50 dark:bg-zinc-900/50 rounded-xl p-5 border border-zinc-100 dark:border-zinc-700">
                            <label class="block text-xs font-semibold text-zinc-500 dark:text-zinc-400 uppercase mb-2">Car Color</label>
                            <p class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">{{ $resident->car_color ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Account Info Sidebar -->
            <div class="border border-zinc-200 dark:border-zinc-700 rounded-2xl p-6 bg-white dark:bg-zinc-800 h-fit shadow-sm">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-lg bg-green-100 dark:bg-green-900/30 flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-zinc-900 dark:text-zinc-100">Account Information</h3>
                </div>
                
                <div class="space-y-5">
                    <div class="bg-zinc-50 dark:bg-zinc-900/50 rounded-xl p-4 border border-zinc-100 dark:border-zinc-700">
                        <label class="block text-xs font-semibold text-zinc-500 dark:text-zinc-400 uppercase mb-2">Email</label>
                        <p class="text-sm font-semibold text-zinc-900 dark:text-zinc-100 break-all flex items-center gap-2">
                            <svg class="w-4 h-4 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            {{ auth()->user()->email }}
                        </p>
                    </div>

                    <div class="bg-zinc-50 dark:bg-zinc-900/50 rounded-xl p-4 border border-zinc-100 dark:border-zinc-700">
                        <label class="block text-xs font-semibold text-zinc-500 dark:text-zinc-400 uppercase mb-2">Member Since</label>
                        <p class="text-sm font-semibold text-zinc-900 dark:text-zinc-100 flex items-center gap-2">
                            <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            {{ auth()->user()->created_at->format('M d, Y') }}
                        </p>
                    </div>

                    <div class="bg-green-50 dark:bg-green-900/20 rounded-xl p-4 border-2 border-green-200 dark:border-green-800">
                        <label class="block text-xs font-semibold text-green-600 dark:text-green-400 uppercase mb-2">Access Status</label>
                        <div class="flex items-center gap-2">
                            <div class="w-3 h-3 bg-green-500 rounded-full animate-pulse"></div>
                            <p class="text-sm font-bold text-green-700 dark:text-green-400">Active</p>
                        </div>
                    </div>
                </div>

                <div class="mt-6 pt-6 border-t border-zinc-200 dark:border-zinc-700">
                    <button @click="showEditModal = true" class="w-full px-4 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white text-center rounded-xl text-sm font-semibold transition shadow-md hover:shadow-lg flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                        </svg>
                        Edit Information
                    </button>
                </div>
            </div>
        </div>

        <!-- Edit Profile Modal -->
        <div x-show="showEditModal" x-cloak @click.away="showEditModal = false" class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:p-0">
                <div class="fixed inset-0 bg-white/80 dark:bg-zinc-900/80 backdrop-blur-sm transition-opacity" @click="showEditModal = false"></div>
                <div class="relative inline-block align-middle bg-white dark:bg-zinc-800 rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:max-w-2xl sm:w-full" @click.stop>
                    <div class="px-8 pt-8 pb-6">
                        <!-- Header with Icon -->
                        <div class="flex items-center justify-between mb-6">
                            <div class="flex items-center gap-4">
                                <div class="flex-shrink-0">
                                    <svg class="w-10 h-10 text-blue-600 dark:text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-semibold text-zinc-900 dark:text-zinc-100" id="modal-title">
                                    Edit Resident
                                </h3>
                            </div>
                            <button @click="showEditModal = false" class="text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-300 transition-colors">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                        
                        <!-- Form -->
                        <form action="{{ route('resident.profile.update') }}" method="POST" class="space-y-5">
                            @csrf
                            @method('PUT')

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Name</label>
                                    <input type="text" id="name" name="name" value="{{ old('name', $resident->name) }}" required 
                                        class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-zinc-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('name') border-red-500 @enderror">
                                    @error('name')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="email" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Email</label>
                                    <input type="email" id="email" name="email" value="{{ old('email', auth()->user()->email) }}" required 
                                        class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-zinc-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('email') border-red-500 @enderror" disabled>
                                    <p class="text-xs text-zinc-500 dark:text-zinc-400 mt-1">Email cannot be changed</p>
                                </div>
                            </div>
                            
                            <div>
                                <label for="password" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Password (leave blank to keep current)</label>
                                <input type="password" id="password" name="password" 
                                    class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-zinc-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('password') border-red-500 @enderror">
                                @error('password')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label for="contact_number" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Contact Number</label>
                                    <input type="tel" id="contact_number" name="contact_number" value="{{ old('contact_number', $resident->contact_number) }}" required
                                        class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-zinc-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('contact_number') border-red-500 @enderror">
                                    @error('contact_number')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="plate_number" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Plate Number</label>
                                    <input type="text" id="plate_number" name="plate_number" value="{{ old('plate_number', $resident->plate_number) }}" required
                                        class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-zinc-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition uppercase font-mono @error('plate_number') border-red-500 @enderror">
                                    @error('plate_number')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <div>
                                <label for="age" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Age</label>
                                <input type="number" id="age" name="age" value="{{ old('age', $resident->age) }}" min="1" max="150"
                                    class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-zinc-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('age') border-red-500 @enderror">
                                @error('age')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="address" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Address</label>
                                <textarea id="address" name="address" rows="3" required
                                    class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-zinc-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('address') border-red-500 @enderror">{{ old('address', $resident->address) }}</textarea>
                                @error('address')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label for="car_model" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Car Model</label>
                                    <input type="text" id="car_model" name="car_model" value="{{ old('car_model', $resident->car_model) }}"
                                        class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-zinc-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('car_model') border-red-500 @enderror">
                                    @error('car_model')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="car_color" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Car Color</label>
                                    <input type="text" id="car_color" name="car_color" value="{{ old('car_color', $resident->car_color) }}"
                                        class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-zinc-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('car_color') border-red-500 @enderror">
                                    @error('car_color')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="flex flex-col-reverse sm:flex-row justify-end gap-3 pt-6 border-t border-zinc-200 dark:border-zinc-700">
                                <button 
                                    type="button" 
                                    @click="showEditModal = false" 
                                    class="px-6 py-3 text-sm font-medium text-zinc-900 dark:text-zinc-100 hover:text-zinc-600 dark:hover:text-zinc-300 transition-colors">
                                    Cancel
                                </button>
                                <button 
                                    type="submit" 
                                    class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors shadow-sm hover:shadow-md">
                                    Update Resident
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
