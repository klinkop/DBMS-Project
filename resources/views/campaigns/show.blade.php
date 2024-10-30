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
            <a href="{{ route('campaigns.edit', $campaign->id) }}"
                class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded">
                Edit Campaign
            </a>

            <form action="{{ route('campaigns.destroy', $campaign->id) }}" method="POST"
                onsubmit="return confirm('Are you sure you want to delete this campaign?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded">
                    Delete Campaign
                </button>
            </form>

            <a href="{{ route('campaigns.index') }}"
                class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                Back to List
            </a>

            <!-- Send to Test Email -->
            <form action="{{ route('campaigns.send', $campaign->id) }}" method="POST" class="flex items-center gap-2">
                @csrf
                <input type="email" name="test_email" value="test@example.com"
                    class="border border-gray-300 p-2 rounded" placeholder="Enter Test Email">
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

            <!-- Schedule Button -->
            <button id="scheduleButton"
                class="bg-purple-500 hover:bg-purple-600 text-white font-bold py-2 px-4 rounded">
                Schedule Campaign
            </button>

            <!-- Schedule Modal -->
            <div id="scheduleModal"
                class="fixed z-50 inset-0 hidden items-center justify-center bg-black bg-opacity-50">
                <div class="bg-white rounded-lg p-6 max-w-sm w-full">
                    <h2 class="text-lg font-semibold mb-4">Schedule Campaign</h2>
                    <form action="{{ route('campaigns.schedule', $campaign->id) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="schedule_time" class="block text-gray-700 font-bold mb-2">Schedule Time</label>
                            <input type="datetime-local" name="schedule_time"
                                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                required>
                        </div>
                        <button type="submit"
                            class="bg-purple-500 hover:bg-purple-600 text-white font-bold py-2 px-4 rounded">
                            Schedule Campaign
                        </button>
                    </form>
                    <div class="mt-4">
                        <button id="closeScheduleModal"
                            class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                            Close
                        </button>
                    </div>
                </div>
            </div>

            <!-- Modal for Success Message -->
            @if (session('success'))
                <div id="successModal"
                    class="fixed z-50 inset-0 flex items-center justify-center bg-black bg-opacity-50">
                    <div class="bg-white rounded-lg p-6 max-w-sm w-full">
                        <h2 class="text-lg font-semibold">Success!</h2>
                        <p>{{ session('success') }}</p>
                        <div class="mt-4">
                            <button id="closeModal"
                                class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Add Recipients Section -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4">Manage Recipients</h3>
            <form action="{{ route('campaigns.addRecipient', $campaign->id) }}" method="POST">
                @csrf
                {{-- <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-bold mb-2">Recipient Name</label>
                    <input type="text" name="name"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        placeholder="Enter recipient name" required>
                </div> --}}
                {{-- <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-bold mb-2">Recipient Email</label>
                    <input type="email" name="email"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                        placeholder="Enter recipient email" required>
                </div> --}}

                <div class="mb-4">
                    <label for="sub_folder_id" class="block text-sm font-medium text-gray-700">Sub Folder:</label>
                    <select name="sub_folder_id" id="sub_folder_id"
                        class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                        <option value="">-- Add Recipient --</option>
                        @foreach ($subFolders as $subFolder)
                            @if (!empty($subFolder) && isset($subFolder->id))
                                <option value="{{ $subFolder->id }}">{{ $subFolder->name }}</option>
                            @endif
                        @endforeach
                    </select>
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
                {{-- <ul class="list-disc pl-5">
                    @foreach ($campaign->recipients as $recipient)
                        <li>
                            {{ $recipient->name ?? 'Unnamed Recipient' }} ({{ $recipient->email ?? 'No Email' }})
                        </li>
                    @endforeach
                </ul> --}}
                <div class="mt-4 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th>No.</th>
                                <th scope="col" class="px-6 py-3 text-left text-gray-900 tracking-wider">
                                    SubFolder
                                </th>
                                <th scope="col" class="px-6 py-3 text-center text-gray-900 tracking-wider">
                                    Emails
                                </th>
                                <th scope="col" class="px-2 py-3 text-center text-gray-900 tracking-wider">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @php
                                $count = 0;
                            @endphp
                            @foreach ($recipients as $recipient)
                                <tr>
                                    <td class="text-center">{{ ++$count }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $recipient->subFolder->name }}
                                        </div>
                                    </td>
                                    <td class="px-2 py-4 whitespace-nowrap text-center">
                                        <div class="flex justify-center">
                                            <button class="text-blue-600 hover:text-blue-800"
                                                onclick="toggleDropdown('dropdown-{{ $recipient->subFolder->id }}')">
                                                View Emails
                                            </button>
                                        </div>
                                        <div id="dropdown-{{ $recipient->subFolder->id }}"
                                            class="hidden mt-2 bg-gray-100 rounded-lg p-2">
                                            <ul>
                                                @foreach ($recipient->subFolder->contactLists as $contactList)
                                                    <li class="text-gray-900">{{ $contactList->email }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </td>
                                    <td class="px-2 py-4 whitespace-nowrap text-center">
                                        <div class="flex justify-center space-x-2">
                                            <!-- Show icon for contact list -->
                                            <a href="{{ route('contactList.index', ['subFolder' => $recipient->subFolder->id]) }}"
                                                class="text-blue-600 hover:text-blue-800" title="Show Contact List">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                    stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-.738 2.118-2.268 3.976-4.283 5.197C15.632 18.713 13.844 19 12 19c-1.844 0-3.632-.287-5.258-1.197C4.726 15.976 3.196 14.118 2.458 12z" />
                                                </svg>
                                            </a>

                                            <!-- Delete icon -->
                                            <form
                                                action="{{ route('campaigns.deleteRecipient', ['campaign' => $recipient->campaign_id, 'recipient' => $recipient->id]) }}"
                                                method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this recipient?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800"
                                                    title="Delete Recipient">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                                        stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M9 3h6l1 1h5v2H4V4h5l1-1zM5 7h14v12a2 2 0 01-2 2H7a2 2 0 01-2-2V7z" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p>No recipient information available.</p>
            @endif
        </div>
    </div>
    <script>
        function toggleDropdown(dropdownId) {
            const dropdown = document.getElementById(dropdownId);
            dropdown.classList.toggle('hidden');
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const successModal = document.getElementById('successModal');
            const closeModalButton = document.getElementById('closeModal');

            if (successModal) {
                // Show the modal when the page loads
                successModal.classList.remove('hidden');

                // Hide the modal when the close button is clicked
                closeModalButton.addEventListener('click', function() {
                    successModal.classList.add('hidden');
                });
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const scheduleModal = document.getElementById('scheduleModal');
            const scheduleButton = document.getElementById('scheduleButton');
            const closeScheduleModalButton = document.getElementById('closeScheduleModal');

            // Show the schedule modal when the button is clicked
            scheduleButton.addEventListener('click', function() {
                scheduleModal.classList.remove('hidden');
            });

            // Hide the schedule modal when the close button is clicked
            closeScheduleModalButton.addEventListener('click', function() {
                scheduleModal.classList.add('hidden');
            });
        });
    </script>
</x-app-layout>
