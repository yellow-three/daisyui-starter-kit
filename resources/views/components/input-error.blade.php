@props([
    'for',
    'bag' => 'default',
])

@error($for, $bag)
    <p {{ $attributes->merge(['class' => 'text-sm text-error']) }} role="alert">{{ $message }}</p>
@enderror
