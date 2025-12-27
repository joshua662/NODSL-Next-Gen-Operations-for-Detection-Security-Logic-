<x-layouts.auth>
    <div class="flex flex-col gap-6">
        <x-auth-header :title="__('Create an account')" :description="__('Enter your details below to create your account')" />

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('register.store') }}" class="flex flex-col gap-6" id="register-form">
            @csrf

            <!-- Name -->
            <flux:input
                name="name"
                :label="__('Name')"
                :value="old('name')"
                type="text"
                required
                autofocus
                autocomplete="name"
                :placeholder="__('Full name')"
            />

            <!-- Email Address -->
            <flux:input
                name="email"
                :label="__('Email address')"
                :value="old('email')"
                type="email"
                required
                autocomplete="email"
                placeholder="email@example.com"
            />

            <!-- Password -->
            <flux:input
                name="password"
                :label="__('Password')"
                type="password"
                required
                autocomplete="new-password"
                :placeholder="__('Password')"
                viewable
            />

            <!-- Confirm Password -->
            <flux:input
                name="password_confirmation"
                :label="__('Confirm password')"
                type="password"
                required
                autocomplete="new-password"
                :placeholder="__('Confirm password')"
                viewable
            />

            <!-- Role Selection -->
            <flux:select
                name="role"
                :label="__('Role')"
                :value="old('role', 'resident')"
                id="role-select"
            >
                <option value="resident">Resident</option>
                <option value="admin">Admin</option>
            </flux:select>

            <!-- Resident-specific fields (shown when role is resident) -->
            <div id="resident-fields">
                <!-- Plate Number -->
                <flux:input
                    name="plate_number"
                    :label="__('Plate Number')"
                    :value="old('plate_number')"
                    type="text"
                    id="plate_number"
                    :placeholder="__('Vehicle plate number')"
                />

                <!-- Contact Number -->
                <flux:input
                    name="phone"
                    :label="__('Contact Number')"
                    :value="old('phone')"
                    type="tel"
                    id="phone"
                    :placeholder="__('Phone number')"
                />

                <!-- Address -->
                <flux:textarea
                    name="address"
                    :label="__('Address')"
                    :value="old('address')"
                    id="address"
                    :placeholder="__('Residential address')"
                />
            </div>

            <div class="flex items-center justify-end">
                <flux:button type="submit" variant="primary" class="w-full">
                    {{ __('Create account') }}
                </flux:button>
            </div>
        </form>

        <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
            <span>{{ __('Already have an account?') }}</span>
            <flux:link :href="route('login')" wire:navigate>{{ __('Log in') }}</flux:link>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const roleSelect = document.getElementById('role-select');
            const residentFields = document.getElementById('resident-fields');
            const plateInput = document.getElementById('plate_number');
            const phoneInput = document.getElementById('phone');
            const addressTextarea = document.getElementById('address');
            
            function toggleResidentFields() {
                if (roleSelect && roleSelect.value === 'admin') {
                    if (residentFields) residentFields.style.display = 'none';
                    if (plateInput) {
                        plateInput.removeAttribute('required');
                        plateInput.value = '';
                    }
                    if (phoneInput) {
                        phoneInput.removeAttribute('required');
                        phoneInput.value = '';
                    }
                    if (addressTextarea) {
                        addressTextarea.removeAttribute('required');
                        addressTextarea.value = '';
                    }
                } else {
                    if (residentFields) residentFields.style.display = 'block';
                    if (plateInput) plateInput.setAttribute('required', 'required');
                    if (phoneInput) phoneInput.setAttribute('required', 'required');
                    if (addressTextarea) addressTextarea.setAttribute('required', 'required');
                }
            }
            
            if (roleSelect) {
                roleSelect.addEventListener('change', toggleResidentFields);
                toggleResidentFields(); // Initial check
            }
        });
    </script>
</x-layouts.auth>
