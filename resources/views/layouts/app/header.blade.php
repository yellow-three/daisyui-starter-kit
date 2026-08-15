<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <div class="drawer lg:drawer-open">
            <input id="app-drawer" type="checkbox" class="drawer-toggle" />

            <div class="drawer-content flex min-h-screen flex-col">
                <header class="border-b bg-base-100">
                    <div class="navbar">
                        <div class="flex items-center gap-2">
                            <label for="app-drawer" class="btn btn-ghost btn-square mr-2 lg:hidden" aria-label="{{ __('Toggle sidebar') }}">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5" aria-hidden="true">
                                    <path d="M4 6h16" />
                                    <path d="M4 12h16" />
                                    <path d="M4 18h16" />
                                </svg>
                            </label>

                            <x-app-logo href="{{ route('dashboard') }}" wire:navigate />

                            <nav class="hidden lg:block">
                                <ul class="menu menu-horizontal gap-1 px-1">
                                    <li>
                                        <a href="{{ route('dashboard') }}" wire:navigate @class(['menu-active' => request()->routeIs('dashboard')])>
                                            {{ __('Dashboard') }}
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>

                        <div class="flex-1"></div>

                        <div class="flex items-center gap-1.5">
                            <nav class="me-1.5 flex items-center gap-0.5">
                                <a href="#" title="{{ __('Search') }}" class="btn btn-ghost btn-square h-10">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5" aria-hidden="true">
                                        <circle cx="11" cy="11" r="8" />
                                        <path d="m21 21-4.3-4.3" />
                                    </svg>
                                </a>
                                <a href="https://github.com/laravel/livewire-starter-kit" target="_blank" title="{{ __('Repository') }}" class="btn btn-ghost btn-square h-10 max-lg:hidden">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5" aria-hidden="true">
                                        <path d="M9 20H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h3.9a2 2 0 0 1 1.69.9l.81 1.2a2 2 0 0 0 1.67.9H20a2 2 0 0 1 2 2v5" />
                                        <circle cx="13" cy="12" r="2" />
                                        <path d="M18 19c-2.8 0-5-2.2-5-5v8" />
                                        <circle cx="20" cy="19" r="2" />
                                    </svg>
                                </a>
                                <a href="https://laravel.com/docs/starter-kits#livewire" target="_blank" title="{{ __('Documentation') }}" class="btn btn-ghost btn-square h-10 max-lg:hidden">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5" aria-hidden="true">
                                        <path d="M12 7v14" />
                                        <path d="M16 12h2" />
                                        <path d="M16 8h2" />
                                        <path d="M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z" />
                                        <path d="M6 12h2" />
                                        <path d="M6 8h2" />
                                    </svg>
                                </a>
                            </nav>

                            <x-desktop-user-menu />
                        </div>
                    </div>
                </header>

                {{ $slot }}
            </div>

            <div class="drawer-side z-40">
                <label for="app-drawer" aria-label="close sidebar" class="drawer-overlay"></label>
                <div class="flex min-h-full w-64 flex-col bg-base-100">
                    <div class="p-4">
                        <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />
                    </div>

                    <ul class="menu flex-1 flex-col gap-1 px-2">
                        <li class="menu-title">{{ __('Platform') }}</li>
                        <li>
                            <a href="{{ route('dashboard') }}" wire:navigate @class(['menu-active' => request()->routeIs('dashboard')])>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5" aria-hidden="true">
                                    <rect width="7" height="7" x="3" y="3" rx="1" />
                                    <rect width="7" height="7" x="14" y="3" rx="1" />
                                    <rect width="7" height="7" x="14" y="14" rx="1" />
                                    <rect width="7" height="7" x="3" y="14" rx="1" />
                                </svg>
                                {{ __('Dashboard') }}
                            </a>
                        </li>

                        <li class="flex-1"></li>

                        <li>
                            <a href="https://github.com/laravel/livewire-starter-kit" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5" aria-hidden="true">
                                    <path d="M9 20H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h3.9a2 2 0 0 1 1.69.9l.81 1.2a2 2 0 0 0 1.67.9H20a2 2 0 0 1 2 2v5" />
                                    <circle cx="13" cy="12" r="2" />
                                    <path d="M18 19c-2.8 0-5-2.2-5-5v8" />
                                    <circle cx="20" cy="19" r="2" />
                                </svg>
                                {{ __('Repository') }}
                            </a>
                        </li>
                        <li>
                            <a href="https://laravel.com/docs/starter-kits#livewire" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5" aria-hidden="true">
                                    <path d="M12 7v14" />
                                    <path d="M16 12h2" />
                                    <path d="M16 8h2" />
                                    <path d="M3 18a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h5a4 4 0 0 1 4 4 4 4 0 0 1 4-4h5a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1h-6a3 3 0 0 0-3 3 3 3 0 0 0-3-3z" />
                                    <path d="M6 12h2" />
                                    <path d="M6 8h2" />
                                </svg>
                                {{ __('Documentation') }}
                            </a>
                        </li>
                    </ul>
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
