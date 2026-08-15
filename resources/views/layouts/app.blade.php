<x-layouts::app.sidebar :title="$title ?? null">
    <main class="flex-1 overflow-y-auto p-4 lg:p-6">
        {{ $slot }}
    </main>
</x-layouts::app.sidebar>
