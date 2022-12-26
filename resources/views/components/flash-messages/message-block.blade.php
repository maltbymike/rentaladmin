@props([
    'for' => ''
])

@error($for) <x-flash-messages.error-message role="alert">{{ $message }}</x-flash-messages.error-message> @enderror

@if (session()->has('success'))
    <x-flash-messages.success-message role="alert">{{ session('success') }}</x-flash-messages.success-message>
@endif
@if (session()->has('warning'))
    <x-flash-messages.warning-message role="alert">{{ session('warning') }}</x-flash-messages.warning-message>
@endif
@if (session()->has('failure'))
    <x-flash-messages.error-message role="alert">{{ session('failure') }}</x-flash-messages.error-message>
@endif