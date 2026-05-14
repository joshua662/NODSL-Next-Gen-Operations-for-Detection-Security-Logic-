@props([
    'title' => null,
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
        <link rel="preconnect" href="https://fonts.bunny.net" />
        <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    </head>
    <body
        class="min-h-dvh overflow-x-hidden bg-neutral-950 text-white antialiased"
        style="font-family: Inter, ui-sans-serif, system-ui, sans-serif"
    >
        @php
            $loginBg = asset('images/login-background.png');
        @endphp

        {{-- Full viewport: cover fills edge-to-edge (no distortion; excess is cropped). --}}
        <div
            class="pointer-events-none fixed inset-0 z-0 bg-neutral-950 bg-cover bg-center bg-no-repeat"
            style="background-image: url('{{ $loginBg }}')"
            aria-hidden="true"
        ></div>

        {{-- Darken for legibility: vertical on small screens, stronger toward the form on lg. --}}
        <div
            class="pointer-events-none fixed inset-0 z-[1] bg-gradient-to-b from-black/40 to-black/60 lg:bg-gradient-to-r lg:from-black/10 lg:via-black/35 lg:to-black/78"
            aria-hidden="true"
        ></div>

        <div class="relative z-10 grid min-h-dvh lg:grid-cols-2">
            {{-- Left column: photo shows through from fixed layer --}}
            <div class="relative hidden min-h-0 lg:block" aria-hidden="true"></div>

            <div
                class="relative flex min-h-dvh flex-col justify-center overflow-x-hidden overflow-y-auto px-8 py-12 sm:px-12 lg:min-h-0 lg:px-16"
            >
                <div class="relative z-10 mx-auto w-full max-w-md">
                    {{-- Frosted panel: blurs the photo/gradient behind this block only --}}
                    <div
                        class="rounded-[1.75rem] border border-white/10 bg-black/30 px-7 py-9 shadow-[0_8px_40px_rgba(0,0,0,0.35)] ring-1 ring-white/5 backdrop-blur-2xl sm:px-10 sm:py-11"
                    >
                        <a
                            href="{{ route('home') }}"
                            class="mb-10 flex items-center gap-2 text-lg font-semibold tracking-tight text-white/95 hover:text-white lg:mb-12"
                            wire:navigate
                        >
                            <span class="flex h-10 w-10 items-center justify-center rounded-md bg-white/10">
                                <x-app-logo-icon class="h-7 fill-current text-white" />
                            </span>
                            {{ config('app.name', 'Laravel') }}
                        </a>

                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>

        @fluxScripts
    </body>
</html>
