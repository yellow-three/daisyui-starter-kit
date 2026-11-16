<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Fortify\Features;
use Livewire\Livewire;

beforeEach(function () {
    /* @chisel-2fa */
    $this->skipUnlessFortifyHas(Features::twoFactorAuthentication());

    Features::twoFactorAuthentication([
        'confirm' => true,
        'confirmPassword' => true,
    ]);
    /* @end-chisel-2fa */
    /* @chisel-passkeys */
    Features::passkeys([
        'confirmPassword' => true,
    ]);
    /* @end-chisel-passkeys */
});

test('security settings page can be rendered', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)
        /* @chisel-password-confirmation */
        ->withSession(['auth.password_confirmed_at' => time()])
        /* @end-chisel-password-confirmation */
        ->get(route('security.edit'));

    $response->assertOk();

    /* @chisel-passkeys */
    $response->assertSee('Passkeys');
    $response->assertSee('No passkeys yet');
    /* @end-chisel-passkeys */
    /* @chisel-2fa */
    $response->assertSee('Two-factor authentication');
    $response->assertSee('Enable 2FA');
    /* @end-chisel-2fa */
});

/* @chisel-password-confirmation */
test('security settings page requires password confirmation when enabled', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)
        ->get(route('security.edit'));

    $response->assertRedirect(route('password.confirm'));
});
/* @end-chisel-password-confirmation */

test('security settings page renders without two factor when feature is disabled', function () {
    config(['fortify.features' => []]);

    $user = User::factory()->create();

    $this->actingAs($user)
        /* @chisel-password-confirmation */
        ->withSession(['auth.password_confirmed_at' => time()])
        /* @end-chisel-password-confirmation */
        ->get(route('security.edit'))
        ->assertOk()
        ->assertSee('Update password')
        ->assertDontSee('Manage your passkeys for passwordless sign-in')
        ->assertDontSee('Add a passkey to sign in without a password')
        ->assertDontSee('Two-factor authentication');
});

/* @chisel-2fa */
test('two factor authentication disabled when confirmation abandoned between requests', function () {
    $user = User::factory()->create();

    $user->forceFill([
        'two_factor_secret' => encrypt('test-secret'),
        'two_factor_recovery_codes' => encrypt(json_encode(['code1', 'code2'])),
        'two_factor_confirmed_at' => null,
    ])->save();

    $this->actingAs($user);

    $component = Livewire::test('pages::settings.security');

    $component->assertSet('twoFactorEnabled', false);

    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'two_factor_secret' => null,
        'two_factor_recovery_codes' => null,
    ]);
});

test('two factor setup does not reveal the secret when already enabled', function () {
    $user = User::factory()->withTwoFactor()->create([
        'two_factor_secret' => encrypt('test-secret'),
    ]);

    $this->actingAs($user);

    Livewire::test('pages::settings.two-factor-setup-modal', ['requiresConfirmation' => true])
        ->call('startTwoFactorSetup')
        ->assertDispatched('two-factor-enabled')
        ->assertSet('manualSetupKey', '')
        ->assertSet('qrCodeSvg', '');

    expect(decrypt($user->refresh()->two_factor_secret))->toBe('test-secret');
});

test('recovery codes are only loaded when requested', function () {
    $user = User::factory()->withTwoFactor()->create([
        'two_factor_recovery_codes' => encrypt(json_encode(['code1', 'code2'])),
    ]);

    $this->actingAs($user);

    Livewire::test('pages::settings.two-factor.recovery-codes')
        ->assertSet('recoveryCodes', [])
        ->call('viewRecoveryCodes')
        ->assertSet('recoveryCodes', ['code1', 'code2']);
});
/* @end-chisel-2fa */

test('password can be updated', function () {
    $user = User::factory()->create([
        'password' => Hash::make('password'),
    ]);

    $this->actingAs($user);

    $response = Livewire::test('pages::settings.security')
        ->set('current_password', 'password')
        ->set('password', 'new-password')
        ->set('password_confirmation', 'new-password')
        ->call('updatePassword');

    $response->assertHasNoErrors();

    expect(Hash::check('new-password', $user->refresh()->password))->toBeTrue();
});

test('correct password must be provided to update password', function () {
    $user = User::factory()->create([
        'password' => Hash::make('password'),
    ]);

    $this->actingAs($user);

    $response = Livewire::test('pages::settings.security')
        ->set('current_password', 'wrong-password')
        ->set('password', 'new-password')
        ->set('password_confirmation', 'new-password')
        ->call('updatePassword');

    $response
        ->assertHasErrors(['current_password'])
        ->assertSee(__('validation.current_password'));
});
