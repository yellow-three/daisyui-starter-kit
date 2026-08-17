# Laravel + Livewire + daisyUI Starter Kit

A fully-featured Laravel starter kit powered by Livewire, daisyUI, and Fortify authentication. Get a beautiful, production-ready application with dark mode, passkeys, and comprehensive settings pages — all styled with daisyUI's semantic design tokens.

## Installation

```bash
laravel new my-app --using=yellow-three/daisyui-starter-kit
```

## Features

- **Fortify Authentication**: Login, registration, password reset, email verification
- **Two-Factor Authentication**: TOTP-based 2FA with QR code setup and recovery codes
- **Passkeys**: WebAuthn passwordless authentication
- **daisyUI 5**: Semantic design tokens with built-in dark/light theme toggle
- **Livewire 4**: Reactive interfaces without JavaScript
- **Sidebar Layout**: Responsive sidebar with mobile hamburger menu
- **Settings Pages**: Profile, appearance (theme toggle), security (2FA, passkeys), delete account
- **Pest 5**: Expressive testing with comprehensive auth test coverage
- **Chisel**: Feature selection during install — choose which auth features to include

## Tech Stack

| Package | Version |
|---------|---------|
| Laravel | 13.x |
| PHP | 8.3+ |
| Livewire | 4.x |
| daisyUI | 5.x |
| Tailwind CSS | 4.x |
| Fortify | 1.x |
| Chisel | 0.1.x |
| Pest | 5.x |

## What's Included

**Auth Pages**: Login, Register, Forgot Password, Reset Password, Email Verification, Two-Factor Challenge, Password Confirmation

**Settings Pages**: Profile (name, email), Appearance (dark/light toggle), Security (2FA setup, passkey management), Delete Account

**Layouts**: App layout with sidebar and header, Auth layouts (card, simple, split)

## Customization

**Changing the Theme**: Edit the theme configuration in your CSS or Tailwind config. daisyUI 5 supports themes via CSS custom properties.

**Adding Colors**: Use daisyUI's semantic color tokens (`primary`, `secondary`, `accent`, etc.) in your Tailwind classes.

**Modifying the Sidebar**: Edit `resources/views/layouts/app/sidebar.blade.php`.

## Chisel Feature Selection

During `laravel new`, Chisel presents an interactive menu to choose which authentication features to include:

- Email verification
- Registration
- Two-factor authentication
- Passkeys
- Password confirmation

Unselected features are automatically removed from the codebase.