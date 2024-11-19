<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Email Template') }}
        </h2>
    </x-slot>
<div class="container">
    <h1>Email Templates</h1>
    @foreach ($templates as $template)
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">{{ $template->title }}</h5>
                <div class="card-text">{!! Str::limit($template->content, 100) !!}</div>
            </div>
        </div>
    @endforeach
</div>
</x-app-layout>
