@props([
    'sidebar' => false,
    'href' => '/',
])

@if($sidebar)
    <a href="{{ $href }}" {{ $attributes->class(['h-10 min-w-0 flex items-center gap-2 px-2']) }}>
        <span class="flex aspect-square size-8 items-center justify-center rounded-md bg-accent-content text-accent-foreground">
            <x-app-logo-icon class="size-5 fill-current text-white dark:text-black" />
        </span>
        <span class="min-w-0 truncate text-sm font-medium text-base-content">
            {{ config('app.name', 'Laravel') }}
        </span>
    </a>
@else
    <a href="{{ $href }}" {{ $attributes->class(['flex h-10 items-center gap-2 me-4']) }}>
        <span class="flex aspect-square size-8 items-center justify-center rounded-md bg-accent-content text-accent-foreground">
            <x-app-logo-icon class="size-5 fill-current text-white dark:text-black" />
        </span>
        <span class="truncate text-sm font-medium text-base-content">
            {{ config('app.name', 'Laravel') }}
        </span>
    </a>
@endif
