@php
    $idPrefix = $idPrefix ?? '';
    $formId = $formId ?? 'register-form';
@endphp

@php
    $fieldClass =
        'w-full rounded-full border border-white/12 bg-white/5 px-5 py-3.5 text-[15px] text-white placeholder:text-white/45 outline-none transition focus:border-white/35 focus:ring-1 focus:ring-white/25';
    $labelClass = 'mb-2 block text-sm font-medium text-white/90';
@endphp

<form method="POST" action="{{ route('register.store') }}" id="{{ $formId }}" class="flex flex-col gap-5">
    @csrf
    <input type="hidden" name="_intent" value="register" />

    <div>
        <label for="{{ $idPrefix }}name" class="{{ $labelClass }}">{{ __('Name') }}</label>
        <input
            id="{{ $idPrefix }}name"
            name="name"
            type="text"
            value="{{ old('name') }}"
            required
            autocomplete="name"
            placeholder="{{ __('Full name') }}"
            class="{{ $fieldClass }}"
        />
        @error('name')
            <p class="mt-1.5 text-sm text-red-300">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="{{ $idPrefix }}email" class="{{ $labelClass }}">{{ __('Email') }}</label>
        <input
            id="{{ $idPrefix }}email"
            name="email"
            type="email"
            value="{{ old('email') }}"
            required
            autocomplete="email"
            placeholder="{{ __('Enter your email address') }}"
            class="{{ $fieldClass }}"
        />
        @error('email')
            <p class="mt-1.5 text-sm text-red-300">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="{{ $idPrefix }}password" class="{{ $labelClass }}">{{ __('Password') }}</label>
        <input
            id="{{ $idPrefix }}password"
            name="password"
            type="password"
            required
            autocomplete="new-password"
            placeholder="{{ __('Password') }}"
            class="{{ $fieldClass }}"
        />
        @error('password')
            <p class="mt-1.5 text-sm text-red-300">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="{{ $idPrefix }}password_confirmation" class="{{ $labelClass }}">{{ __('Confirm password') }}</label>
        <input
            id="{{ $idPrefix }}password_confirmation"
            name="password_confirmation"
            type="password"
            required
            autocomplete="new-password"
            placeholder="{{ __('Confirm password') }}"
            class="{{ $fieldClass }}"
        />
        @error('password_confirmation')
            <p class="mt-1.5 text-sm text-red-300">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="{{ $idPrefix }}role-select" class="{{ $labelClass }}">{{ __('Role') }}</label>
        <select
            id="{{ $idPrefix }}role-select"
            name="role"
            class="{{ $fieldClass }} appearance-none bg-[length:1rem] bg-[right_1rem_center] bg-no-repeat pr-11"
            style="background-image: url('data:image/svg+xml,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 fill=%27none%27 viewBox=%270 0 24 24%27 stroke=%27rgba(255,255,255,0.5)%27%3E%3Cpath stroke-linecap=%27round%27 stroke-linejoin=%27round%27 stroke-width=%272%27 d=%27M19 9l-7 7-7-7%27/%3E%3C/svg%3E')"
        >
            <option value="resident" @selected(old('role', 'resident') === 'resident')>{{ __('Resident') }}</option>
            <option value="admin" @selected(old('role') === 'admin')>{{ __('Admin') }}</option>
        </select>
        @error('role')
            <p class="mt-1.5 text-sm text-red-300">{{ $message }}</p>
        @enderror
    </div>

    <div id="{{ $idPrefix }}resident-fields" class="flex flex-col gap-5">
        <div>
            <label for="{{ $idPrefix }}plate_number" class="{{ $labelClass }}">{{ __('Plate number') }}</label>
            <input
                id="{{ $idPrefix }}plate_number"
                name="plate_number"
                type="text"
                value="{{ old('plate_number') }}"
                autocomplete="off"
                placeholder="{{ __('Vehicle plate number') }}"
                class="{{ $fieldClass }}"
            />
            @error('plate_number')
                <p class="mt-1.5 text-sm text-red-300">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="{{ $idPrefix }}phone" class="{{ $labelClass }}">{{ __('Contact number') }}</label>
            <input
                id="{{ $idPrefix }}phone"
                name="phone"
                type="tel"
                value="{{ old('phone') }}"
                autocomplete="tel"
                placeholder="{{ __('Phone number') }}"
                class="{{ $fieldClass }}"
            />
            @error('phone')
                <p class="mt-1.5 text-sm text-red-300">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="{{ $idPrefix }}address" class="{{ $labelClass }}">{{ __('Address') }}</label>
            <textarea
                id="{{ $idPrefix }}address"
                name="address"
                rows="3"
                autocomplete="street-address"
                placeholder="{{ __('Residential address') }}"
                class="min-h-[100px] w-full resize-y rounded-2xl border border-white/12 bg-white/5 px-5 py-3.5 text-[15px] text-white placeholder:text-white/45 outline-none transition focus:border-white/35 focus:ring-1 focus:ring-white/25"
            >{{ old('address') }}</textarea>
            @error('address')
                <p class="mt-1.5 text-sm text-red-300">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <button
        type="submit"
        class="mt-2 w-full rounded-full bg-white py-3.5 text-center text-sm font-bold text-neutral-950 shadow-sm transition hover:bg-white/95 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white/70"
    >
        {{ __('Create account') }}
    </button>
</form>

<script>
    (function () {
        const prefix = @json($idPrefix);

        function $(id) {
            return document.getElementById(prefix + id);
        }

        function toggleResidentFields() {
            const roleSelect = $('role-select');
            const residentFields = $('resident-fields');
            const plateInput = $('plate_number');
            const phoneInput = $('phone');
            const addressTextarea = $('address');

            if (!roleSelect) {
                return;
            }

            if (roleSelect.value === 'admin') {
                if (residentFields) {
                    residentFields.style.display = 'none';
                }
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
                if (residentFields) {
                    residentFields.style.display = 'block';
                }
                if (plateInput) {
                    plateInput.setAttribute('required', 'required');
                }
                if (phoneInput) {
                    phoneInput.setAttribute('required', 'required');
                }
                if (addressTextarea) {
                    addressTextarea.setAttribute('required', 'required');
                }
            }
        }

        function bind() {
            const roleSelect = $('role-select');
            if (roleSelect) {
                roleSelect.removeEventListener('change', toggleResidentFields);
                roleSelect.addEventListener('change', toggleResidentFields);
                toggleResidentFields();
            }
        }

        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', bind);
        } else {
            bind();
        }
    })();
</script>
