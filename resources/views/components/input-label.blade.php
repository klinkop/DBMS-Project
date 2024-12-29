@props(['value'])

<label {{ $attributes->merge(['class' => 'input-group input-group-outline my-3']) }}>
    {{ $value ?? $slot }}
</label>
