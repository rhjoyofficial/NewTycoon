@props(['name' => null, 'show' => false, 'focusable' => false])

<div {{ $attributes->merge(['class' => ($show ? '' : 'hidden ') . 'fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4']) }}>
    <div class="w-full max-w-lg rounded-2xl bg-white p-6 shadow-xl">
        {{ $slot }}
    </div>
</div>
