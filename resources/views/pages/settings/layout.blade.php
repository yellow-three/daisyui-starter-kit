<div class="flex items-start max-md:flex-col">
    <div class="me-10 w-full pb-4 md:w-[220px]">
        <nav aria-label="{{ __('Settings') }}" class="flex flex-col">
            <a
                href="{{ route('profile.edit') }}"
                wire:navigate
                @class([
                    'h-10 lg:h-8 relative flex items-center gap-3 rounded-lg py-0 text-start w-full px-3 my-px border border-transparent',
                    'text-(--color-accent-content) bg-zinc-800/[4%] dark:bg-white/[7%]' => request()->routeIs('profile.edit'),
                    'text-zinc-500 dark:text-white/80 hover:text-zinc-800 dark:hover:text-white hover:bg-zinc-800/[4%] dark:hover:bg-white/[7%]' => ! request()->routeIs('profile.edit'),
                ])
            >
                <div class="flex-1 text-sm font-medium leading-none whitespace-nowrap">{{ __('Profile') }}</div>
            </a>

            <a
                href="{{ route('security.edit') }}"
                wire:navigate
                @class([
                    'h-10 lg:h-8 relative flex items-center gap-3 rounded-lg py-0 text-start w-full px-3 my-px border border-transparent',
                    'text-(--color-accent-content) bg-zinc-800/[4%] dark:bg-white/[7%]' => request()->routeIs('security.edit'),
                    'text-zinc-500 dark:text-white/80 hover:text-zinc-800 dark:hover:text-white hover:bg-zinc-800/[4%] dark:hover:bg-white/[7%]' => ! request()->routeIs('security.edit'),
                ])
            >
                <div class="flex-1 text-sm font-medium leading-none whitespace-nowrap">{{ __('Security') }}</div>
            </a>

            <a
                href="{{ route('appearance.edit') }}"
                wire:navigate
                @class([
                    'h-10 lg:h-8 relative flex items-center gap-3 rounded-lg py-0 text-start w-full px-3 my-px border border-transparent',
                    'text-(--color-accent-content) bg-zinc-800/[4%] dark:bg-white/[7%]' => request()->routeIs('appearance.edit'),
                    'text-zinc-500 dark:text-white/80 hover:text-zinc-800 dark:hover:text-white hover:bg-zinc-800/[4%] dark:hover:bg-white/[7%]' => ! request()->routeIs('appearance.edit'),
                ])
            >
                <div class="flex-1 text-sm font-medium leading-none whitespace-nowrap">{{ __('Appearance') }}</div>
            </a>
        </nav>
    </div>

    <div role="none" class="h-px w-full bg-zinc-800/15 dark:bg-white/20 md:hidden"></div>

    <div class="flex-1 self-stretch max-md:pt-6">
        <h2 class="text-sm font-medium text-zinc-800 dark:text-white">{{ $heading ?? '' }}</h2>
        <p class="text-sm text-zinc-500 dark:text-white/70">{{ $subheading ?? '' }}</p>

        <div class="mt-5 w-full max-w-lg">
            {{ $slot }}
        </div>
    </div>
</div>
