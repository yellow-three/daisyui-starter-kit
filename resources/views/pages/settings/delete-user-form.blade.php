<?php

use Livewire\Component;

new class extends Component {}; ?>

<section class="mt-10 space-y-6">
    <div class="relative mb-5">
        <h2 class="text-sm font-medium text-base-content">{{ __('Delete account') }}</h2>
        <p class="text-sm text-base-content/70">{{ __('Delete your account and all of its resources') }}</p>
    </div>

    <button
        type="button"
        data-test="delete-user-button"
        x-on:click="$dispatch('modal-show', { name: 'confirm-user-deletion' })"
        class="btn btn-error"
    >
        {{ __('Delete account') }}
    </button>

    <livewire:pages::settings.delete-user-modal />
</section>
