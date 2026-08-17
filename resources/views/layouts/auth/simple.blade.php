<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-base-100 antialiased">
        <div class="bg-base-200 flex min-h-svh flex-col items-center justify-center gap-6 p-6 md:p-10">
            <div class="flex w-full max-w-sm flex-col gap-2">
                <a href="{{ route('home') }}" class="flex flex-col items-center gap-2 font-medium" wire:navigate>
                    <span class="flex h-9 w-9 mb-1 items-center justify-center rounded-md">
                        <x-app-logo-icon class="size-9 fill-current text-black dark:text-white" />
                    </span>
                    <span class="sr-only">{{ config('app.name', 'Laravel') }}</span>
                </a>
                <div class="flex flex-col gap-6">
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
