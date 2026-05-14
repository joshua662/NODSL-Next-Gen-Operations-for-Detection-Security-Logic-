<x-layouts.auth.login-split>
    <div class="flex flex-col gap-8">
        <div class="flex flex-col gap-2 text-center">
            <h1 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">{{ __('Sign up') }}</h1>
            <p class="text-base font-normal text-white/60">{{ __('Please enter your details to create your account.') }}</p>
        </div>

        <x-auth-session-status class="text-center text-sm font-medium text-emerald-300" :status="session('status')" />

        @include('partials.auth.register-form', [
            'formId' => 'register-form-page',
            'idPrefix' => '',
        ])

        <p class="text-center text-sm text-white/60">
            {{ __('Already have an account?') }}
            <a
                href="{{ route('login') }}"
                class="font-bold text-white underline-offset-4 hover:underline"
                wire:navigate
            >
                {{ __('Log in') }}
            </a>
        </p>
    </div>
</x-layouts.auth.login-split>
