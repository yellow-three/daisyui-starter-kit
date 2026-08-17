<?php

use App\Concerns\PasswordValidationRules;
use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

new class extends Component {
    use PasswordValidationRules;

    public string $password = '';

    /**
     * Delete the currently authenticated user.
     */
    public function deleteUser(Logout $logout): void
    {
        $this->validate([
            'password' => $this->currentPasswordRules(),
        ]);

        tap(Auth::user(), $logout(...))->delete();

        $this->redirect('/', navigate: true);
    }
}; ?>

<dialog
    class="modal"
    x-data="{ open: false }"
    x-on:modal-show.window="if ($event.detail.name === 'confirm-user-deletion') { open = true; $el.showModal() }"
    x-on:cancel="open = false"
    x-on:close="if (open) $el.showModal()"
>
    <div class="modal-box max-w-lg">
        <form method="POST" wire:submit="deleteUser" class="space-y-6">
            <div>
                <h3 class="text-base font-medium text-base-content">{{ __('Are you sure you want to delete your account?') }}</h3>

                <p class="text-sm text-base-content/70">
                    {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
                </p>
            </div>

            <div class="flex flex-col gap-3">
                <label for="password" class="text-sm font-medium text-base-content">{{ __('Password') }}</label>

                <div class="relative" x-data="{ show: false }">
                    <input
                        id="password"
                        name="password"
                        wire:model="password"
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

                @error('password')
                    <div class="alert alert-error" role="alert">
                        <svg class="size-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                        </svg>
                        <span>{{ $message }}</span>
                    </div>
                @enderror
            </div>

            <div class="flex justify-end space-x-2 rtl:space-x-reverse">
                <button
                    type="button"
                    x-on:click="open = false; $el.closest('dialog').close()"
                    class="btn btn-soft btn-neutral"
                >
                    {{ __('Cancel') }}
                </button>

                <button type="submit" data-test="confirm-delete-user-button" class="btn btn-error">
                    {{ __('Delete account') }}
                </button>
            </div>
        </form>
    </div>

    <form method="dialog" class="modal-backdrop" x-on:click="open = false">
        <button type="button">{{ __('Close') }}</button>
    </form>
</dialog>
