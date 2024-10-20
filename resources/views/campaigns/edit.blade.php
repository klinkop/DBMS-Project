<!-- resources/views/campaigns/edit.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Campaign') }}
        </h2>
    </x-slot>

    <div class="container mx-auto py-8">
        <form action="{{ route('campaigns.update', $campaign->id) }}" method="POST" class="bg-white shadow-md rounded-lg p-6">
            @csrf
            @method('PUT')

            <!-- Campaign Name -->
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-bold mb-2">Campaign Name</label>
                <input type="text" name="name" id="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ $campaign->name }}" required>
            </div>

            <!-- Description -->
            <div class="mb-4">
                <label for="description" class="block text-gray-700 font-bold mb-2">Description</label>
                <textarea name="description" id="description" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" rows="2">{{ $campaign->description }}</textarea>
            </div>

            <!-- Email Subject -->
            <div class="mb-4">
                <label for="email_subject" class="block text-gray-700 font-bold mb-2">Email Subject</label>
                <input type="text" name="email_subject" id="email_subject" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" value="{{ $campaign->email_subject }}" required>
            </div>

            <!-- Email Body -->
            <div class="mb-4">
                <label for="email_body" class="block text-gray-700 font-bold mb-2">Email Body</label>
                <textarea name="email_body" id="email_body" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" rows="8" required>{{ $campaign->email_body }}</textarea>
            </div>

            <!-- Scheduled At -->
            <div class="mb-4">
                <label for="scheduled_at" class="block text-gray-700 font-bold mb-2">Scheduled At</label>
                <input type="datetime-local" name="scheduled_at" id="scheduled_at" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                       value="{{ optional($campaign->scheduled_at)->format('Y-m-d\TH:i') }}">
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                    Update Campaign
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
