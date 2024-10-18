<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manage Campaign') }}
        </h2>
    </x-slot>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <form method="POST" action="{{ route('campaigns.update', $campaign) }}">
            @csrf
            @method('patch')
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Campaign Name</label>
                <input id="name" type="text" name="name"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                    value="{{ old('name', $campaign->name) }}">
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
            <div class="mb-4">
                <label for="user_id" class="block text-sm font-medium text-gray-700">Sender</label>
                <p
                    class="block w-full bg-white border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm p-2">
                    {{ auth()->user()->name }}
                </p>
            </div>
            <div class="mb-4">
                <label for="subject" class="block text-sm font-medium text-gray-700">Subject</label>
                <input type="text" id="subject" name="subject"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                    value="{{ old('subject', $campaign->subject) }}">
                <x-input-error :messages="$errors->get('subject')" class="mt-2" />
            </div>
            <div class="mb-4">
                <label for="design" class="block text-sm font-medium text-gray-700">Design</label>
                <textarea id="design" name="design"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                    {{ trim(old('design', $campaign->design)) }}
                </textarea>
                <x-input-error :messages="$errors->get('design')" class="mt-2" />
            </div>
            <div class="mt-4 space-x-2">
                <x-primary-button>{{ __('Save') }}</x-primary-button>
                <a href="{{ route('campaigns.index') }}">{{ __('Cancel') }}</a>
            </div>
        </form>
    </div>
</x-app-layout>
