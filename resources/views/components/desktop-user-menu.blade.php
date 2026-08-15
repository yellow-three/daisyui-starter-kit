@props([
    'name' => null,
])

<div {{ $attributes->class(['dropdown dropdown-end']) }}>
    <div tabindex="0" role="button" class="flex items-center gap-2 rounded-btn p-1.5 hover:bg-zinc-200/70 dark:hover:bg-zinc-800" data-test="sidebar-menu-button">
        <div class="avatar placeholder">
            <div class="w-8 rounded-full bg-accent-content text-sm text-accent-foreground">
                <span>{{ auth()->user()->initials() }}</span>
            </div>
        </div>

        <span class="truncate text-sm font-medium text-zinc-500 dark:text-white/80">
            {{ auth()->user()->name }}
        </span>

        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="size-4 text-zinc-400 dark:text-white/80" aria-hidden="true">
            <path d="m7 15 5 5 5-5" />
            <path d="m7 9 5-5 5 5" />
        </svg>
    </div>

    <ul tabindex="-1" class="dropdown-content menu z-[1] mt-2 w-64 rounded-box border border-zinc-200 bg-white p-2 shadow-lg dark:border-zinc-700 dark:bg-zinc-900">
        <li>
            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                <div class="avatar placeholder">
                    <div class="w-8 rounded-full bg-accent-content text-accent-foreground">
                        <span>{{ auth()->user()->initials() }}</span>
                    </div>
                </div>

                <div class="grid flex-1 text-start text-sm leading-tight">
                    <span class="truncate font-medium">{{ auth()->user()->name }}</span>
                    <span class="truncate text-zinc-500 dark:text-zinc-400">{{ auth()->user()->email }}</span>
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
