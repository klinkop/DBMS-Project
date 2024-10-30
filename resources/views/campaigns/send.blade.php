<x-app-layout>
   <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Send Email') }}
        </h2>
    </x-slot>
<form action="{{ route('campaigns.send', $campaign->id) }}" method="POST">
    @csrf
    <label for="recipient_emails">Recipient Emails (comma separated):</label>
    <input type="text" name="recipient_emails[]" placeholder="recipient@example.com" required>
    <button type="submit">Send Campaign</button>
</form>
</x-app-layout>
