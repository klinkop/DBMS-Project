<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Campaigns') }}
        </h2>
    </x-slot>

    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-semibold mb-6">Campaign Details</h1>

        <!-- Campaign details card -->
        <div class="bg-white shadow-md rounded-lg mb-6 p-6">
            <div class="mb-4">
                <h3 class="text-xl font-semibold">{{ $campaign->name }}</h3>
            </div>
            <div class="mb-4">
                <p><strong>Description:</strong> {{ $campaign->description }}</p>
                <p><strong>Email Subject:</strong> {{ $campaign->email_subject }}</p>
                <p><strong>Email Body:</strong></p>
                <div class="bg-gray-100 p-4 rounded-lg">
                    {!! $campaign->email_body !!}
                </div>
                <p class="mt-4"><strong>Scheduled At:</strong>
                    {{ $campaign->scheduled_at ? \Carbon\Carbon::parse($campaign->scheduled_at)->format('Y-m-d H:i') : 'Not Scheduled' }}
                </p>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-wrap gap-4 mb-6">
            <a href="{{ route('campaigns.edit', $campaign->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded">
                Edit Campaign
            </a>

            <form action="{{ route('campaigns.destroy', $campaign->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this campaign?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">
                    Delete Campaign
                </button>
            </form>

            <a href="{{ route('campaigns.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                Back to List
            </a>

            <!-- Send to Test Email -->
            <form action="{{ route('campaigns.send', $campaign->id) }}" method="POST" class="flex items-center gap-2">
                @csrf
                <input type="email" name="test_email" value="test@example.com" class="border border-gray-300 p-2 rounded" placeholder="Enter Test Email">
                <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                    Send to Test Email
                </button>
            </form>

            <!-- Send to All Recipients -->
            <form action="{{ route('campaigns.sendAll', $campaign->id) }}" method="POST">
                @csrf
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                    Send Now
                </button>
            </form>
            <!-- Modal for Success Message -->
            @if (session('success'))
                <div id="successModal" class="fixed z-50 inset-0 flex items-center justify-center bg-black bg-opacity-50">
                    <div class="bg-white rounded-lg p-6 max-w-sm w-full">
                        <h2 class="text-lg font-semibold">Success!</h2>
                        <p>{{ session('success') }}</p>
                        <div class="mt-4">
                            <button id="closeModal" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Add Recipients Section -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4">Add Recipient to Campaign</h3>
            <form action="{{ route('campaigns.addRecipient', $campaign->id) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-bold mb-2">Recipient Name</label>
                    <input type="text" name="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Enter recipient name" required>
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-bold mb-2">Recipient Email</label>
                    <input type="email" name="email" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Enter recipient email" required>
                </div>
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                    Add Recipient
                </button>
            </form>

            <h4 class="text-lg font-semibold mt-6 mb-4">Current Recipients</h4>
            @if ($errors->any())
                <div class="mb-4">
                    <ul class="text-red-500">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if ($campaign->recipients && $campaign->recipients->isEmpty())
                <p>No recipients added yet.</p>
            @elseif ($campaign->recipients)
                <ul class="list-disc pl-5">
                    @foreach ($campaign->recipients as $recipient)
                        <li>
                            {{ $recipient->name ?? 'Unnamed Recipient' }} ({{ $recipient->email ?? 'No Email' }})
                        </li>
                    @endforeach
                </ul>
            @else
                <p>No recipient information available.</p>
            @endif
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const successModal = document.getElementById('successModal');
            const closeModalButton = document.getElementById('closeModal');

            if (successModal) {
                // Show the modal when the page loads
                successModal.classList.remove('hidden');

                // Hide the modal when the close button is clicked
                closeModalButton.addEventListener('click', function () {
                    successModal.classList.add('hidden');
                });
            }
        });
    </script>
</x-app-layout>
