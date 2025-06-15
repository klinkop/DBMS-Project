<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn bg-gradient-dark']) }}>
    {{ $slot }}
</button>
