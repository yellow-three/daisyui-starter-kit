<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>
    {{ filled($title ?? null) ? $title.' - '.config('app.name', 'Laravel') : config('app.name', 'Laravel') }}
</title>

<link rel="icon" href="/favicon.ico" sizes="any">
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">

@fonts

@vite(['resources/css/app.css', 'resources/js/app.js'])

<script>
// Apply the stored theme synchronously at parse time (before Alpine boots) to avoid a flash of light/dark.
(function () {
    const stored = localStorage.getItem('theme');
    const initialRaw = stored || 'light';
    const initialDark = initialRaw === 'dark' || (initialRaw === 'system' && window.matchMedia('(prefers-color-scheme: dark)').matches);
    document.documentElement.setAttribute('data-theme', initialDark ? 'dark' : 'light');
    document.documentElement.classList.toggle('dark', initialDark);
})();

// Re-apply the theme after a wire:navigate morphs in fresh server HTML (no hardcoded class on <html>).
document.addEventListener('livewire:navigated', () => Alpine.store('theme')?.apply());

document.addEventListener('alpine:init', () => {
    Alpine.store('theme', {
        raw: 'light',
        get dark() {
            if (this.raw === 'dark') return true;
            if (this.raw === 'system') {
                return window.matchMedia('(prefers-color-scheme: dark)').matches;
            }
            return false;
        },
        init() {
            const stored = localStorage.getItem('theme');
            if (stored) {
                this.raw = stored;
            }
            this.apply();
            this.listenForSystemChanges();
        },
        apply() {
            const resolved = this.dark ? 'dark' : 'light';
            document.documentElement.setAttribute('data-theme', resolved);
            document.documentElement.classList.toggle('dark', this.dark);
        },
        set(value) {
            this.raw = value;
            localStorage.setItem('theme', value);
            this.apply();
        },
        listenForSystemChanges() {
            const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
            mediaQuery.addEventListener('change', () => {
                if (this.raw === 'system') {
                    this.apply();
                }
            });
        }
    });

    // Listen for theme-change events from other components
    window.addEventListener('theme-change', (event) => {
        if (event.detail && event.detail.theme) {
            Alpine.store('theme').set(event.detail.theme);
        }
    });
});
</script>
