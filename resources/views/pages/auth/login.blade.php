<x-layouts::auth :title="__('Log in')">
    <div class="flex flex-col gap-6">
        <x-auth-header :title="__('Log in to your account')" :description="__('Enter your email and password below to log in')" />

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        {{-- @chisel-passkeys --}}
        <x-passkey-verify />
        {{-- @end-chisel-passkeys --}}

        <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-6">
            @csrf

            <!-- Email Address -->
            <div class="flex flex-col gap-3">
                <label for="email" class="text-sm font-medium text-base-content">
                    {{ __('Email address') }}
                </label>

                <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    autocomplete="email"
                    placeholder="email@example.com"
                    class="input w-full"
                />
            </div>

            <!-- Password -->
            <div class="flex flex-col gap-3">
                <div class="flex items-center justify-between gap-4">
                    <label for="password" class="text-sm font-medium text-base-content">
                        {{ __('Password') }}
                    </label>

                    @if (Route::has('password.request'))
                        <a
                            href="{{ route('password.request') }}"
                            wire:navigate
                            class="text-sm font-medium text-[var(--color-accent-content)] underline underline-offset-[6px] hover:decoration-current"
                        >
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif
                </div>

                <div class="relative" x-data="{ show: false }">
                    <input
                        id="password"
                        name="password"
                        type="password"
                        :type="show ? 'text' : 'password'"
                        required
                        autocomplete="current-password"
                        placeholder="{{ __('Password') }}"
                        class="input w-full pe-10"
                    />

                    <button
                        type="button"
                        x-on:click="show = !show"
                        aria-label="{{ __('Toggle password visibility') }}"
                        class="absolute inset-y-0 end-0 flex items-center pe-3 text-base-content/50 hover:text-base-content"
                    >
                        <svg :class="show ? 'hidden' : ''" class="size-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                        </svg>

                        <svg :class="show ? '' : 'hidden'" class="size-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Remember Me -->
            <label class="flex items-center gap-2 text-sm font-medium text-base-content">
                <input type="checkbox" name="remember" value="1" class="checkbox checkbox-primary" @checked(old('remember')) />
                {{ __('Remember me') }}
            </label>

            <div class="flex items-center justify-end">
                <button type="submit" class="btn btn-primary w-full" data-test="login-button">
                    {{ __('Log in') }}
                </button>
            </div>
        </form>

        {{-- @chisel-registration --}}
        <div class="space-x-1 text-sm text-center rtl:space-x-reverse text-base-content/60">
            <span>{{ __('Don\'t have an account?') }}</span>
            <a href="{{ route('register') }}" wire:navigate class="text-sm font-medium text-[var(--color-accent-content)] underline underline-offset-[6px] hover:decoration-current">{{ __('Sign up') }}</a>
        </div>
        {{-- @end-chisel-registration --}}
    </div>
</x-layouts::auth>
