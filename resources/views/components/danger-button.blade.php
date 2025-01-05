<button {{ $attributes->merge(['type' => 'submit', 'class' => 'btn btn-danger btn-link']) }}>
    {{ $slot }}
</button>
