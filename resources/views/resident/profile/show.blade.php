<x-layouts.app :title="__('My Profile')">
    <div class="flex h-full w-full flex-1 flex-col gap-4">
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
                    <a href="{{ route('resident.profile.edit') }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition">
                        ✏️ Edit Profile
                    </a>
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

                <a href="{{ route('resident.profile.edit') }}" class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-center rounded-lg text-sm font-medium transition block">
                    Edit Information
                </a>
            </div>
        </div>
    </div>
</x-layouts.app>
