@props([
    'title',
    'description',
])

<div class="flex w-full flex-col text-center">
    <h2 class="text-2xl font-medium text-base-content">{{ $title }}</h2>
    <p class="mt-2 text-sm text-base-content/70">{{ $description }}</p>
</div>
