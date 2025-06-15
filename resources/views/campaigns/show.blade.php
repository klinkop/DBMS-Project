<x-layout bodyClass="g-sidenav-show  bg-gray-200">

    <x-navbars.sidebar activePage='campaign'></x-navbars.sidebar>

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">

        <style>
            .hidden{
                display: none
            }
            .flex{
                display: flex
            }
            .hover\:text-red-800:hover {
                --tw-text-opacity: 1;
                color: rgb(153 27 27 / var(--tw-text-opacity));
            }
            #scheduleModal {
                display: none;
                position: fixed;
                inset: 0;
                z-index: 50;
                align-items: center;
                justify-content: center;
                background: rgba(0, 0, 0, 0.5); /* Dimmed background */
                backdrop-filter: blur(5px); /* Blurred background */
            }

            #scheduleModal.active {
                display: flex; /* Show modal when active */
            }

            #scheduleModal .card {
                position: relative;
                width: 90%; /* Adjust as needed */
                max-width: 400px;
                padding: 20px;
                background: #fff; /* Modal background */
                border-radius: 8px;
                box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
                animation: scaleIn 0.3s ease-in-out;
            }

            /* Animation for modal appearance */
            @keyframes scaleIn {
                0% {
                    transform: scale(0.8);
                    opacity: 0;
                }
                100% {
                    transform: scale(1);
                    opacity: 1;
                }
            }

            /* Close button styling */
            #closeScheduleModal {
                position: absolute;
                top: 10px;
                right: 10px;
                background: transparent;
                border: none;
                color: #000;
                cursor: pointer;
                font-size: 18px;
            }

            #closeScheduleModal:hover {
                color: red;
            }

        </style>

        <x-navbars.navs.auth titlePage="Manage Campaign"></x-navbars.navs.auth>

        <div class="container mx-auto">

            <div class="card-body p-3">
                <!-- Send to Test Email -->
                <div class="row">
                    <div class="col-md-4">
                        <a href="{{ route('campaigns.index') }}"
                            class="btn bg-gradient-dark">
                            Back
                        </a>
                    </div>
                    <div class="col-md-4">
                        <form action="{{ route('campaigns.send', $campaign->id) }}" method="POST">
                            @csrf
                            <div class="col-md-6">
                            <button type="submit" class="btn bg-gradient-dark">
                                Send to Test Email
                            </button>
                            <input type="email" name="test_email" value="test@example.com" class="form-control border border-2 p-2"
                                placeholder="Enter Test Email">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <h1 class="mb-1 text-2xl font-semibold">Campaign Details</h1>

            <!-- Campaign details card -->
            <div class="card card-body" style="overflow: hidden; max-height: 1800px;"> <!-- Adjust padding -->
                <div class="card card-plain">
                    <div class="card-header pb-0 p-3">
                        <div class="row">
                            <div class="col-md-8 d-flex align-items-center">
                                <h6 class="mb-3 col-md-6">{{ $campaign->name }}</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        <div class="row">
                            <p class="mb-3 col-md-6"><strong>Description:</strong> {{ $campaign->description }}</p>
                            <p class="mb-3 col-md-6"><strong>Sender Name:</strong> {{ $campaign->sender_name ?? config('mail.from.name') }}</p>
                            <p class="mb-3 col-md-6"><strong>Email Subject:</strong> {{ $campaign->email_subject }}</p>
                            <p class="mb-3 col-md-6"><strong>Scheduled At:</strong>
                                {{ $campaign->scheduled_at ? \Carbon\Carbon::parse($campaign->scheduled_at)->format('Y-m-d H:i') : 'Not Scheduled' }}
                            </p>
                            <p class="mb-3 col-md-6""><strong>Status:</strong> {{ ucfirst($campaign->status) }}</p>
                        </div>
                        <div class="row"> <!-- Scaling down -->
                            <p class="mb-3 col-md-12"><strong>Email Body:</strong></p>
                            <div class="mb-3 col-md-12"> <!-- Inner padding to control the inner content -->
                                {!! $campaign->email_body_html !!}
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <!-- Action Buttons -->
            <div class="mb-2 flex-wrap mt-4 gap-4">
                <div class="flex gap-2">
                @if ($campaign->status !== 'sent' && $campaign->status !== 'scheduled')
                    <a href="{{ route('campaigns.edit', $campaign->id) }}"
                        class="btn bg-gradient-dark">
                        Edit Campaign
                    </a>

                    <form action="{{ route('campaigns.destroy', $campaign->id) }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to delete this campaign?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            Delete Campaign
                        </button>
                    </form>

                    <!-- Send to All Recipients -->
                    <form action="{{ route('campaigns.sendAll', $campaign->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn bg-gradient-dark">
                            Send Now
                        </button>
                    </form>

                    <!-- Schedule Button -->
                    <button id="openScheduleModal"
                        class="btn bg-gradient-dark">
                        Schedule Campaign
                    </button>
                @else
                    <p class="font-bold text-red-500">This campaign has already been sent or scheduled and cannot be edited or
                        rescheduled.</p>
                @endif
                </div>

                    <!-- Schedule Modal -->
                    <div id="scheduleModal">
                        <div class="card card-body">
                            <h2 class="mb-4 text-lg font-semibold">Schedule Campaign</h2>
                            <form action="{{ route('campaigns.schedule', $campaign->id) }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label for="schedule_time" class="mb-2 block font-bold text-gray-700">Schedule Time</label>
                                    <input type="datetime-local" name="schedule_time"
                                        class="focus:shadow-outline w-full appearance-none rounded border px-3 py-2 leading-tight text-gray-700 shadow focus:outline-none"
                                        required>
                                </div>
                                <button type="submit" class="btn bg-gradient-dark">
                                    Schedule Campaign
                                </button>
                            </form>
                            <button id="closeScheduleModal" class="btn btn-danger btn-link">
                                <i class="material-icons">close</i>
                            </button>
                        </div>
                    </div>

                <!-- Modal for Success Message -->
                @if (session('success'))
                <div id="successModal"
                    style="position: fixed; top: 0; left: 0; right: 0; bottom: 0; z-index: 50; display: none; align-items: center; justify-content: center; background-color: rgba(0, 0, 0, 0.5);">
                    <div style="width: 100%; max-width: 24rem; border-radius: 8px; background-color: #ffffff; padding: 1.5rem; position: relative;">
                        <!-- Close button positioned at the top-right corner -->
                        <button id="closeModal"
                            style="position: absolute; top: 10px; right: 10px; background: transparent; border: none; color: #dc3545; cursor: pointer; font-size: 1.5rem;">
                            <i class="material-icons">close</i>
                        </button>

                        <h2 style="font-size: 1.125rem; font-weight: 600;">Success!</h2>
                        <p>{{ session('success') }}</p>
                    </div>
                </div>
                @endif
            </div>

            <!-- Add Recipients Section -->
            @if ($campaign->status !== 'sent' && $campaign->status !== 'scheduled')
            <div class="card card-body">
                <h3 class="mb-4 text-lg font-semibold">Manage Recipients</h3>
                <form action="{{ route('campaigns.addRecipient', $campaign->id) }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="sub_folder_id" class="form-label">Sub Folder:</label>
                        <select name="sub_folder_id" id="sub_folder_id"
                            class="form-control border border-2 p-2">
                            <option value="">-- Add Recipient --</option>
                            @foreach ($subFolders as $subFolder)
                                @if (!empty($subFolder) && isset($subFolder->id))
                                    <option value="{{ $subFolder->id }}">{{ $subFolder->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn bg-gradient-dark">
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

                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
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
                            <tbody class="">
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
                                            <div class="">
                                                <button class="btn bg-gradient-dark"
                                                    onclick="toggleDropdown('dropdown-{{ $recipient->subFolder->id }}')">
                                                    View Emails
                                                </button>
                                            </div>
                                            <div id="dropdown-{{ $recipient->subFolder->id }}"
                                                class="card card-body hidden">
                                                <ul>
                                                    @foreach ($recipient->subFolder->contactLists as $contactList)
                                                        <li class="text-gray-900">{{ $contactList->email }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </td>
                                        <td class="whitespace-nowrap px-2 py-4 text-center">
                                            <div class="justify-center space-x-2">
                                                <!-- Show icon for contact list -->
                                                <a href="{{ route('contactList.index', ['subFolder' => $recipient->subFolder->id]) }}"
                                                    class="pb-2" title="Show Contact List">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
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
                                                        title="Delete Recipient" style="border: transparent; background: transparent;">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8"
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
                </div>
                @else
                    <p>No recipient information available.</p>
                @endif
            </div>
            @endif
        </div>
        <div class="botts"><x-footers.auth></x-footers.auth></div>
    </main>
    <x-plugins></x-plugins>
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
                // Show the modal when the page loads by setting display to flex
                successModal.style.display = 'flex';

                // Hide the modal when the close button is clicked by setting display to none
                if (closeModalButton) {
                    closeModalButton.addEventListener('click', function() {
                        successModal.style.display = 'none';
                    });
                }
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const scheduleModal = document.getElementById('scheduleModal');
            const openScheduleModal = document.getElementById('openScheduleModal');
            const closeScheduleModal = document.getElementById('closeScheduleModal');

            if (!scheduleModal || !openScheduleModal || !closeScheduleModal) {
                console.error('Modal elements not found. Check your HTML IDs.');
                return;
            }

            // Open modal
            openScheduleModal.addEventListener('click', function () {
                scheduleModal.classList.add('active');
            });

            // Close modal
            closeScheduleModal.addEventListener('click', function () {
                scheduleModal.classList.remove('active');
            });
        });
    </script>

</x-app-layout>
