<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-base-100 antialiased">
        <div class="relative grid h-dvh flex-col items-center justify-center px-8 sm:px-0 lg:max-w-none lg:grid-cols-2 lg:px-0">
            <div class="bg-base-200 relative hidden h-full flex-col p-10 text-white lg:flex dark:border-e dark:border-base-300">
                <div class="absolute inset-0 bg-base-300"></div>
                <a href="{{ route('home') }}" class="relative z-20 flex items-center text-lg font-medium" wire:navigate>
                    <span class="flex h-10 w-10 items-center justify-center rounded-md">
                        <x-app-logo-icon class="me-2 h-7 fill-current text-white" />
                    </span>
                    {{ config('app.name', 'Laravel') }}
                </a>

                @php
                    [$message, $author] = str(Illuminate\Foundation\Inspiring::quotes()->random())->explode('-');
                @endphp

                <div class="relative z-20 mt-auto">
                    <blockquote class="space-y-2">
                        <h2 class="text-lg font-medium">&ldquo;{{ trim($message) }}&rdquo;</h2>
                        <footer><p class="text-sm">{{ trim($author) }}</p></footer>
                    </blockquote>
                </div>
            </div>
            <div class="w-full lg:p-8">
                <div class="mx-auto flex w-full flex-col justify-center space-y-6 sm:w-[350px]">
                    <a href="{{ route('home') }}" class="z-20 flex flex-col items-center gap-2 font-medium lg:hidden" wire:navigate>
                        <span class="flex h-9 w-9 items-center justify-center rounded-md">
                            <x-app-logo-icon class="size-9 fill-current text-black dark:text-white" />
                        </span>

                        <span class="sr-only">{{ config('app.name', 'Laravel') }}</span>
                    </a>
                    {{ $slot }}
                </div>
            </div>
        </div>

        @persist('toast')
        <div
            x-data="{ show: false, type: 'success', message: '' }"
            x-on:toast-show.window="show = true; type = $event.detail.type ?? $event.detail[0]?.type ?? 'success'; message = $event.detail.message ?? $event.detail[0]?.message ?? ''; setTimeout(() => show = false, 4000)"
            x-show="show"
            x-transition.opacity.duration.300ms
            class="toast toast-end z-[100]"
        >
            <div class="alert" :class="type === 'error' ? 'alert-error' : 'alert-success'">
                <span x-text="message"></span>
            </div>
        </div>
        @endpersist

        @livewireScripts
    </body>
</html>
