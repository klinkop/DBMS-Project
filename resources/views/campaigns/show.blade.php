<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Campaigns') }}
        </h2>
    </x-slot>

    <div class="container mx-auto py-8">
        <a href="{{ route('campaigns.index') }}"
            class="rounded bg-gray-500 px-4 py-2 font-bold text-white hover:bg-gray-600">
            Back to List
        </a>

        <!-- Send to Test Email -->
        <form action="{{ route('campaigns.send', $campaign->id) }}" method="POST" class="flex items-center gap-2">
            @csrf
            <input type="email" name="test_email" value="test@example.com" class="rounded border border-gray-300 p-2"
                placeholder="Enter Test Email">
            <button type="submit" class="rounded bg-green-500 px-4 py-2 font-bold text-white hover:bg-green-600">
                Send to Test Email
            </button>
        </form>
        <h1 class="mb-6 text-2xl font-semibold">Campaign Details</h1>

        <!-- Campaign details card -->
        <div class="mb-6 rounded-lg bg-white shadow-md p-4" style="overflow: hidden; max-height: 1800px;"> <!-- Adjust padding -->
            <div class="mb-3">
                <h3 class="text-xl font-semibold">{{ $campaign->name }}</h3>
            </div>

            <p class="mb-2"><strong>Description:</strong> {{ $campaign->description }}</p>
            <p><strong>Sender Name:</strong> {{ $campaign->sender_name ?? config('mail.from.name') }}</p>
            <p class="mb-2"><strong>Email Subject:</strong> {{ $campaign->email_subject }}</p>
            <p class="mb-2"><strong>Scheduled At:</strong>
                {{ $campaign->scheduled_at ? \Carbon\Carbon::parse($campaign->scheduled_at)->format('Y-m-d H:i') : 'Not Scheduled' }}
            </p>
            <p class="mb-2"><strong>Status:</strong> {{ ucfirst($campaign->status) }}</p>
            <p class="mb-2"><strong>Email Body:</strong></p>
            <div class="rounded-lg bg-gray-100" style="transform: scale(0.7); transform-origin: top; padding: 0; margin: 0; overflow: hidden;"> <!-- Scaling down -->
                <div class="p-2"> <!-- Inner padding to control the inner content -->
                    {!! $campaign->email_body !!}
                </div>
            </div>

        </div>

        <!-- Action Buttons -->
        <div class="mb-6 flex flex-wrap gap-4">
            @if ($campaign->status !== 'sent' && $campaign->status !== 'scheduled')
                <a href="{{ route('campaigns.edit', $campaign->id) }}"
                    class="rounded bg-yellow-500 px-4 py-2 font-bold text-white hover:bg-yellow-600">
                    Edit Campaign
                </a>

                <form action="{{ route('campaigns.destroy', $campaign->id) }}" method="POST"
                    onsubmit="return confirm('Are you sure you want to delete this campaign?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="rounded bg-red-500 px-4 py-2 font-bold text-white hover:bg-red-600">
                        Delete Campaign
                    </button>
                </form>

                <!-- Send to All Recipients -->
                <form action="{{ route('campaigns.sendAll', $campaign->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="rounded bg-blue-500 px-4 py-2 font-bold text-white hover:bg-blue-600">
                        Send Now
                    </button>
                </form>

                <!-- Schedule Button -->
                <button id="scheduleButton"
                    class="rounded bg-purple-500 px-4 py-2 font-bold text-white hover:bg-purple-600">
                    Schedule Campaign
                </button>
            @else
                <p class="font-bold text-red-500">This campaign has already been sent or scheduled and cannot be edited or
                    rescheduled.</p>
            @endif

            <!-- Schedule Modal -->
            <div id="scheduleModal"
                class="fixed inset-0 z-50 flex hidden items-center justify-center bg-black bg-opacity-50">
                <div class="w-full max-w-sm rounded-lg bg-white p-6 shadow-lg">
                    <h2 class="mb-4 text-lg font-semibold">Schedule Campaign</h2>
                    <form action="{{ route('campaigns.schedule', $campaign->id) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="schedule_time" class="mb-2 block font-bold text-gray-700">Schedule Time</label>
                            <input type="datetime-local" name="schedule_time"
                                class="focus:shadow-outline w-full appearance-none rounded border px-3 py-2 leading-tight text-gray-700 shadow focus:outline-none"
                                required>
                        </div>
                        <button type="submit"
                            class="rounded bg-purple-500 px-4 py-2 font-bold text-white hover:bg-purple-600">
                            Schedule Campaign
                        </button>
                    </form>
                    <div class="mt-4">
                        <button id="closeScheduleModal"
                            class="rounded bg-gray-500 px-4 py-2 font-bold text-white hover:bg-gray-600">
                            Close
                        </button>
                    </div>
                </div>
            </div>

            <!-- Modal for Success Message -->
            @if (session('success'))
                <div id="successModal"
                    class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
                    <div class="w-full max-w-sm rounded-lg bg-white p-6">
                        <h2 class="text-lg font-semibold">Success!</h2>
                        <p>{{ session('success') }}</p>
                        <div class="mt-4">
                            <button id="closeModal"
                                class="rounded bg-blue-500 px-4 py-2 font-bold text-white hover:bg-blue-600">
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            @endif
        </div>

                <!-- Add Recipients Section -->
        @if ($campaign->status !== 'sent' && $campaign->status !== 'scheduled')
        <div class="rounded-lg bg-white p-6 shadow-md">
            <h3 class="mb-4 text-lg font-semibold">Manage Recipients</h3>
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
                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        <option value="">-- Add Recipient --</option>
                        @foreach ($subFolders as $subFolder)
                            @if (!empty($subFolder) && isset($subFolder->id))
                                <option value="{{ $subFolder->id }}">{{ $subFolder->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="rounded bg-blue-500 px-4 py-2 font-bold text-white hover:bg-blue-600">
                    Add Recipient
                </button>
            </form>

            <h4 class="mb-4 mt-6 text-lg font-semibold">Current Recipients</h4>
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
                                <th scope="col" class="px-6 py-3 text-left tracking-wider text-gray-900">
                                    SubFolder
                                </th>
                                <th scope="col" class="px-6 py-3 text-center tracking-wider text-gray-900">
                                    Emails
                                </th>
                                <th scope="col" class="px-2 py-3 text-center tracking-wider text-gray-900">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            @php
                                $count = 0;
                            @endphp
                            @foreach ($recipients as $recipient)
                                <tr>
                                    <td class="text-center">{{ ++$count }}</td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $recipient->subFolder->name }}
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-2 py-4 text-center">
                                        <div class="flex justify-center">
                                            <button class="text-blue-600 hover:text-blue-800"
                                                onclick="toggleDropdown('dropdown-{{ $recipient->subFolder->id }}')">
                                                View Emails
                                            </button>
                                        </div>
                                        <div id="dropdown-{{ $recipient->subFolder->id }}"
                                            class="mt-2 hidden rounded-lg bg-gray-100 p-2">
                                            <ul>
                                                @foreach ($recipient->subFolder->contactLists as $contactList)
                                                    <li class="text-gray-900">{{ $contactList->email }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </td>
                                    <td class="whitespace-nowrap px-2 py-4 text-center">
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
        @endif
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
