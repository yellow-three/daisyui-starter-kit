<x-layouts::auth :title="__('Forgot password')">
    <div class="flex flex-col gap-6">
        <x-auth-header :title="__('Forgot password')" :description="__('Enter your email to receive a password reset link')" />

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}" class="flex flex-col gap-6">
            @csrf

            <!-- Email Address -->
            <div class="flex flex-col gap-3">
                <label for="email" class="text-sm font-medium text-zinc-800 dark:text-white">
                    {{ __('Email address') }}
                </label>

                <input
                    id="email"
                    name="email"
                    type="email"
                    required
                    autofocus
                    placeholder="email@example.com"
                    class="input w-full"
                />
            </div>

            <button type="submit" class="btn btn-primary w-full" data-test="email-password-reset-link-button">
                {{ __('Email password reset link') }}
            </button>
        </form>

        <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-400">
            <span>{{ __('Or, return to') }}</span>
            <a href="{{ route('login') }}" wire:navigate class="text-sm font-medium text-[var(--color-accent-content)] underline underline-offset-[6px] hover:decoration-current">{{ __('log in') }}</a>
        </div>
    </div>
</x-layouts::auth>
