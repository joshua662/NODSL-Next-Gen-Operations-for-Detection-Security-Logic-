@php
    $openRegisterModal = $errors->isNotEmpty() && old('_intent') === 'register';
@endphp

<x-layouts.auth.login-split>
    <div class="flex flex-col gap-10">
        <div class="flex flex-col gap-2 text-center">
            <h1 class="text-3xl font-bold tracking-tight text-white sm:text-4xl">{{ __('Welcome back') }}</h1>
            <p class="text-base font-normal text-white/70">{{ __('Please enter your details.') }}</p>
        </div>

        <x-auth-session-status class="text-center text-sm font-medium text-emerald-300" :status="session('status')" />

        <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-8 text-left">
            @csrf

            <div class="flex flex-col gap-6">
                <div class="flex flex-col gap-2">
                    <label for="email" class="text-sm font-semibold text-white">{{ __('E-mail') }}</label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        autocomplete="email"
                        placeholder="{{ __('Enter your e-mail') }}"
                        class="w-full border-0 border-b border-white/45 bg-transparent py-2.5 text-[15px] text-white placeholder:text-white/55 placeholder:font-normal focus:border-white focus:outline-none focus:ring-0"
                    />
                    @error('email')
                        @unless (old('_intent') === 'register')
                            <p class="text-sm text-red-300">{{ $message }}</p>
                        @endunless
                    @enderror
                </div>

                <div class="flex flex-col gap-2">
                    <label for="password" class="text-sm font-semibold text-white">{{ __('Password') }}</label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        required
                        autocomplete="current-password"
                        placeholder="Password"
                        class="w-full border-0 border-b border-white/45 bg-transparent py-2.5 text-[15px] text-white placeholder:text-white/55 placeholder:font-normal focus:border-white focus:outline-none focus:ring-0"
                    />
                    @error('password')
                        @unless (old('_intent') === 'register')
                            <p class="text-sm text-red-300">{{ $message }}</p>
                        @endunless
                    @enderror
                </div>
            </div>

            <div class="flex flex-wrap items-center justify-between gap-3">
                <label class="flex cursor-pointer items-center gap-2.5 text-sm text-white/90">
                    <input
                        type="checkbox"
                        name="remember"
                        value="1"
                        @checked(old('remember'))
                        class="size-4 rounded border border-white/50 bg-white/5 text-neutral-900 focus:ring-2 focus:ring-white/40 focus:ring-offset-0"
                    />
                    <span class="font-medium">{{ __('Remember me') }}</span>
                </label>

                @if (Route::has('password.request'))
                    <a
                        href="{{ route('password.request') }}"
                        class="text-sm font-semibold text-white underline-offset-4 hover:underline"
                        wire:navigate
                    >
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>

            <button
                type="submit"
                class="w-full rounded-md bg-black py-3.5 text-center text-sm font-bold text-white shadow-sm transition hover:bg-neutral-900 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-white/80"
                data-test="login-button"
            >
                {{ __('Log in') }}
            </button>
        </form>

        @if (Route::has('register'))
            <p class="text-center text-sm text-white/70">
                {{ __("Don't have an account?") }}
                <button
                    type="button"
                    id="open-register-modal"
                    class="font-bold text-white underline-offset-4 hover:underline"
                >
                    {{ __('Register here') }}
                </button>
            </p>
        @endif
    </div>

    @if (Route::has('register'))
        <dialog
            id="register-modal"
            class="w-[min(100%,26rem)] max-w-[calc(100vw-1.25rem)] rounded-[1.75rem] border-0 bg-transparent p-0 shadow-none backdrop:bg-black/60 backdrop:backdrop-blur-md"
        >
            <div
                class="relative max-h-[min(90dvh,40rem)] overflow-y-auto rounded-[1.75rem] border border-white/10 bg-neutral-950/90 px-6 py-8 shadow-[0_8px_48px_rgba(0,0,0,0.55)] ring-1 ring-white/10 backdrop-blur-2xl sm:px-8 sm:py-9"
            >
                <button
                    type="button"
                    class="absolute end-3 top-3 flex size-9 items-center justify-center rounded-full text-white/70 transition hover:bg-white/10 hover:text-white"
                    onclick="document.getElementById('register-modal').close()"
                    aria-label="{{ __('Close') }}"
                >
                    <span class="text-xl leading-none" aria-hidden="true">&times;</span>
                </button>

                <div class="mb-6 flex flex-col items-center gap-3 pt-2 text-center">
                    <span
                        class="flex size-11 items-center justify-center rounded-full border border-white/15 bg-white/5"
                        aria-hidden="true"
                    >
                        <x-app-logo-icon class="size-6 fill-current text-white" />
                    </span>
                    <h2 class="text-2xl font-bold tracking-tight text-white">{{ __('Sign up') }}</h2>
                    <p class="text-sm text-white/55">{{ __('Please enter your details to create your account.') }}</p>
                </div>

                @include('partials.auth.register-form', [
                    'formId' => 'register-form-modal',
                    'idPrefix' => 'modal-',
                ])

                <p class="mt-6 text-center text-sm text-white/55">
                    {{ __('Already have an account?') }}
                    <button
                        type="button"
                        class="font-bold text-white underline-offset-4 hover:underline"
                        onclick="document.getElementById('register-modal').close()"
                    >
                        {{ __('Log in') }}
                    </button>
                </p>
            </div>
        </dialog>

        <script>
            (function () {
                const dialog = document.getElementById('register-modal');
                const openBtn = document.getElementById('open-register-modal');
                if (!dialog || !openBtn) return;

                openBtn.addEventListener('click', function () {
                    if (typeof dialog.showModal === 'function') {
                        dialog.showModal();
                    }
                });

                dialog.addEventListener('click', function (e) {
                    if (e.target === dialog) {
                        dialog.close();
                    }
                });

                @if ($openRegisterModal)
                    document.addEventListener('DOMContentLoaded', function () {
                        if (typeof dialog.showModal === 'function') {
                            dialog.showModal();
                        }
                    });
                @endif
            })();
        </script>
    @endif
</x-layouts.auth.login-split>
