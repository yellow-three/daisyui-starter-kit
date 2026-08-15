@props([
    'title',
    'description',
])

<div class="flex w-full flex-col text-center">
    <h2 class="text-2xl font-medium text-zinc-800 dark:text-white">{{ $title }}</h2>
    <p class="mt-2 text-sm text-zinc-500 dark:text-white/70">{{ $description }}</p>
</div>
