<x-layouts.app :title="__('Edit Profile')">
    <div class="flex h-full w-full flex-1 flex-col gap-4">
        <!-- Header -->
        <div class="mb-6">
            <h1 class="text-3xl font-bold text-zinc-900 dark:text-zinc-100">✏️ Edit Profile</h1>
            <p class="text-zinc-600 dark:text-zinc-400 mt-1">Update your personal and vehicle information (changes require admin approval)</p>
        </div>

        @php
            $resident = auth()->user()->resident;
        @endphp

        <div class="max-w-2xl">
            <form action="{{ route('resident.profile.update') ?? '#' }}" method="POST" class="border border-zinc-200 dark:border-zinc-700 rounded-xl p-6 bg-white dark:bg-zinc-800 space-y-6">
                @csrf
                @method('PUT')

                <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">👤 Personal Information</h3>

                <!-- Full Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Full Name *</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $resident->name) }}" required 
                        class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-zinc-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Age -->
                <div>
                    <label for="age" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Age</label>
                    <input type="number" id="age" name="age" value="{{ old('age', $resident->age) }}" min="1" max="150"
                        class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-zinc-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('age') border-red-500 @enderror">
                    @error('age')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Contact Number -->
                <div>
                    <label for="contact_number" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Contact Number *</label>
                    <input type="tel" id="contact_number" name="contact_number" value="{{ old('contact_number', $resident->contact_number) }}" required
                        class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-zinc-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('contact_number') border-red-500 @enderror">
                    @error('contact_number')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Address -->
                <div>
                    <label for="address" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Address *</label>
                    <textarea id="address" name="address" rows="3" required
                        class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-zinc-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('address') border-red-500 @enderror">{{ old('address', $resident->address) }}</textarea>
                    @error('address')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <hr class="border-zinc-200 dark:border-zinc-700">

                <h3 class="text-lg font-semibold text-zinc-900 dark:text-zinc-100">🚗 Vehicle Information</h3>

                <!-- Plate Number -->
                <div>
                    <label for="plate_number" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Plate Number *</label>
                    <input type="text" id="plate_number" name="plate_number" value="{{ old('plate_number', $resident->plate_number) }}" required
                        placeholder="e.g., ABC-1234"
                        class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-zinc-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition uppercase font-mono @error('plate_number') border-red-500 @enderror">
                    @error('plate_number')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Car Model -->
                <div>
                    <label for="car_model" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Car Model</label>
                    <input type="text" id="car_model" name="car_model" value="{{ old('car_model', $resident->car_model) }}"
                        placeholder="e.g., Honda Civic 2020"
                        class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-zinc-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('car_model') border-red-500 @enderror">
                    @error('car_model')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Car Color -->
                <div>
                    <label for="car_color" class="block text-sm font-medium text-zinc-700 dark:text-zinc-300 mb-2">Car Color</label>
                    <input type="text" id="car_color" name="car_color" value="{{ old('car_color', $resident->car_color) }}"
                        placeholder="e.g., White"
                        class="w-full px-4 py-2 border border-zinc-300 dark:border-zinc-600 rounded-lg bg-white dark:bg-zinc-700 text-zinc-900 dark:text-zinc-100 focus:ring-2 focus:ring-blue-500 focus:border-transparent transition @error('car_color') border-red-500 @enderror">
                    @error('car_color')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <hr class="border-zinc-200 dark:border-zinc-700">

                <!-- Info Alert -->
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                    <p class="text-sm text-blue-900 dark:text-blue-200">
                        <strong>ℹ️ Note:</strong> Your changes will be submitted for admin review and approval. You will receive a notification once your request is processed.
                    </p>
                </div>

                <!-- Form Actions -->
                <div class="flex gap-3 pt-4">
                    <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition">
                        Submit Changes
                    </button>
                    <a href="{{ route('resident.profile.show') }}" class="px-6 py-2 border border-zinc-300 dark:border-zinc-600 text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-700 rounded-lg text-sm font-medium transition">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
