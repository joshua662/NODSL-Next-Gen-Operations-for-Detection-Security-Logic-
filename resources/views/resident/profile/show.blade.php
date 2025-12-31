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
        @endphp

        <div class="grid gap-6 lg:grid-cols-3">
            <!-- Profile Card -->
            <div class="lg:col-span-2 border border-zinc-200 dark:border-zinc-700 rounded-xl p-6 bg-white dark:bg-zinc-800">
                <div class="flex items-start justify-between mb-6">
                    <h2 class="text-xl font-semibold text-zinc-900 dark:text-zinc-100">Personal Information</h2>
                    <button @click="showEditModal = true" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition">
                        ✏️ Edit Profile
                    </button>
                </div>

                <div class="grid gap-6 md:grid-cols-2">
                    <!-- First Name -->
                    <div>
                        <label class="block text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase mb-2">First Name</label>
                        <p class="text-lg font-medium text-zinc-900 dark:text-zinc-100">{{ explode(' ', $resident->name)[0] ?? $resident->name }}</p>
                    </div>

                    <!-- Middle Name -->
                    <div>
                        <label class="block text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase mb-2">Middle Name</label>
                        <p class="text-lg font-medium text-zinc-900 dark:text-zinc-100">-</p>
                    </div>

                    <!-- Last Name -->
                    <div>
                        <label class="block text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase mb-2">Last Name</label>
                        <p class="text-lg font-medium text-zinc-900 dark:text-zinc-100">{{ implode(' ', array_slice(explode(' ', $resident->name), 1)) ?? '-' }}</p>
                    </div>

                    <!-- Age -->
                    <div>
                        <label class="block text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase mb-2">Age</label>
                        <p class="text-lg font-medium text-zinc-900 dark:text-zinc-100">{{ $resident->age ?? '-' }}</p>
                    </div>

                    <!-- Gender -->
                    <div>
                        <label class="block text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase mb-2">Gender</label>
                        <p class="text-lg font-medium text-zinc-900 dark:text-zinc-100">-</p>
                    </div>

                    <!-- Birthdate -->
                    <div>
                        <label class="block text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase mb-2">Birthdate</label>
                        <p class="text-lg font-medium text-zinc-900 dark:text-zinc-100">-</p>
                    </div>

                    <!-- Contact Number -->
                    <div>
                        <label class="block text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase mb-2">Contact Number</label>
                        <p class="text-lg font-medium text-zinc-900 dark:text-zinc-100">{{ $resident->contact_number ?? '-' }}</p>
                    </div>

                    <!-- Address -->
                    <div>
                        <label class="block text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase mb-2">Address</label>
                        <p class="text-lg font-medium text-zinc-900 dark:text-zinc-100">{{ $resident->address ?? '-' }}</p>
                    </div>
                </div>

                <hr class="my-6 border-zinc-200 dark:border-zinc-700">

                <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100 mb-4">🚗 Vehicle Information</h3>

                <div class="grid gap-6 md:grid-cols-2">
                    <!-- Plate Number -->
                    <div>
                        <label class="block text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase mb-2">Plate Number</label>
                        <p class="text-lg font-medium text-zinc-900 dark:text-zinc-100 font-mono bg-zinc-100 dark:bg-zinc-700 p-3 rounded">{{ $resident->plate_number ?? '-' }}</p>
                    </div>

                    <!-- Car Model -->
                    <div>
                        <label class="block text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase mb-2">Car Model</label>
                        <p class="text-lg font-medium text-zinc-900 dark:text-zinc-100">{{ $resident->car_model ?? '-' }}</p>
                    </div>

                    <!-- Car Color -->
                    <div>
                        <label class="block text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase mb-2">Car Color</label>
                        <p class="text-lg font-medium text-zinc-900 dark:text-zinc-100">{{ $resident->car_color ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Account Info Sidebar -->
            <div class="border border-zinc-200 dark:border-zinc-700 rounded-xl p-6 bg-white dark:bg-zinc-800 h-fit">
                <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100 mb-4">Account Information</h3>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase mb-1">Email</label>
                        <p class="text-sm text-zinc-900 dark:text-zinc-100">{{ auth()->user()->email }}</p>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase mb-1">Member Since</label>
                        <p class="text-sm text-zinc-900 dark:text-zinc-100">{{ auth()->user()->created_at->format('M d, Y') }}</p>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-zinc-600 dark:text-zinc-400 uppercase mb-1">Access Status</label>
                        <div class="flex items-center gap-2 mt-1">
                            <div class="w-2 h-2 bg-green-600 rounded-full"></div>
                            <p class="text-sm text-green-600 dark:text-green-400 font-medium">Active</p>
                        </div>
                    </div>
                </div>

                <hr class="my-4 border-zinc-200 dark:border-zinc-700">

                <button @click="showEditModal = true" class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-center rounded-lg text-sm font-medium transition">
                    Edit Information
                </button>
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
