<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-base-100">
        <div class="drawer lg:drawer-open">
            <input id="app-drawer" type="checkbox" class="drawer-toggle" />

            <!-- Mobile header -->
            <div class="drawer-content flex min-h-screen flex-col">
                <header class="flex items-center gap-2 border-b border-base-300 bg-base-100 px-4 py-3 lg:hidden">
                    <label for="app-drawer" class="btn btn-ghost btn-square shrink-0" aria-label="{{ __('Toggle sidebar') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9h16.5m-16.5 6.75h16.5" />
                        </svg>
                    </label>

                    <div class="flex-1"></div>

                    <div class="dropdown dropdown-end">
                        <div tabindex="0" role="button" class="flex items-center gap-2 rounded-btn p-1.5 hover:bg-base-200/70">
                            <div class="avatar placeholder">
                                <div class="w-8 rounded-full bg-accent-content text-sm text-accent-foreground">
                                    <span>{{ auth()->user()->initials() }}</span>
                                </div>
                            </div>

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4 text-base-content/60" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                            </svg>
                        </div>

                        <ul tabindex="-1" class="dropdown-content menu z-[1] mt-2 w-64 rounded-box border border-base-300 bg-base-100 p-2 shadow-lg">
                            <li>
                                <div class="flex items-center gap-3 px-1 py-1.5 text-start text-sm">
                                    <div class="avatar placeholder">
                                        <div class="w-10 rounded-full bg-accent-content text-accent-foreground">
                                            <span>{{ auth()->user()->initials() }}</span>
                                        </div>
                                    </div>

                                    <div class="grid flex-1 text-start text-sm leading-tight">
                                        <span class="truncate font-medium">{{ auth()->user()->name }}</span>
                                        <span class="truncate text-base-content/60">{{ auth()->user()->email }}</span>
                                    </div>
                                </div>
                            </li>

                            <li></li>

                            <li>
                                <a href="{{ route('profile.edit') }}" wire:navigate>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12a7.5 7.5 0 0 0 15 0m-15 0a7.5 7.5 0 1 1 15 0m-15 0H3m16.5 0H21m-1.5 0H12m-8.457 3.077 1.41-.513m14.095-5.13 1.41-.513M5.106 17.785l1.15-.964m11.49-9.642 1.149-.964M7.501 19.795l.75-1.3m7.5-12.99.75-1.3m-6.063 16.658.26-1.477m2.605-14.772.26-1.477m0 17.726-.26-1.477M10.698 4.614l-.26-1.477M16.5 19.794l-.75-1.299M7.5 4.205 12 12m6.894 5.785-1.149-.964M6.256 7.178l-1.15-.964m15.352 8.864-1.41-.513M4.954 9.435l-1.41-.514M12.002 12l-3.75 6.495" />
                                    </svg>

                                    {{ __('Settings') }}
                                </a>
                            </li>

                            <li></li>

                            <li>
                                <form method="POST" action="{{ route('logout') }}" class="grid w-full grid-cols-1!">
                                    @csrf
                                    <button type="submit" class="flex w-full cursor-pointer items-center gap-2 text-start" data-test="logout-button">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                                        </svg>

                                        {{ __('Log out') }}
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </header>

                {{ $slot }}
            </div>

            <!-- Sidebar -->
            <div class="drawer-side z-20 lg:overflow-visible">
                <label for="app-drawer" aria-label="{{ __('Close sidebar') }}" class="drawer-overlay"></label>

                <aside class="flex min-h-dvh w-64 flex-col gap-4 border-e border-base-300 bg-base-100 p-4">
                    <div class="flex items-center justify-between gap-2">
                        <x-app-logo :sidebar="true" href="{{ route('dashboard') }}" wire:navigate />

                        <label for="app-drawer" class="btn btn-ghost btn-square lg:hidden" aria-label="{{ __('Close sidebar') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5" aria-hidden="true">
                                <path d="m7 15 5 5 5-5" />
                                <path d="m7 9 5-5 5 5" />
                            </svg>
                        </label>
                    </div>

                    <ul class="menu w-full rounded-box">
                        <li class="menu-title">{{ __('Platform') }}</li>
                        <li>
                            <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'menu-active' : '' }}" wire:navigate>
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-5" aria-hidden="true">
                                    <rect width="7" height="7" x="3" y="3" rx="1" />
                                    <rect width="7" height="7" x="14" y="3" rx="1" />
                                    <rect width="7" height="7" x="14" y="14" rx="1" />
                                    <rect width="7" height="7" x="3" y="14" rx="1" />
                                </svg>

                                {{ __('Dashboard') }}
                            </a>
                        </li>
                    </ul>

                    <div class="flex-1"></div>

                    <ul class="menu w-full rounded-box">
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

                    <x-desktop-user-menu class="hidden lg:block" :name="auth()->user()->name" />
                </aside>
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
