<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Contact List') }}
        </h2>
    </x-slot>
    <div class="mx-auto p-4 sm:p-6 lg:p-8 w-full max-w-full md:max-w-3xl lg:max-w-5xl xl:max-w-7xl">
        {{-- <a href="{{ route('contactList.create') }}"
            class="inline-flex items-center px-4 py-2 mt-4 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            {{ __('Create Contact') }}
        </a> --}}

        {{-- Add Search Form --}}
        <form action="{{ route('contactList.index') }}" method="get" class="mt-4 space-y-4">
            <!-- Hidden input for subFolder_id -->
            <input type="hidden" name="subFolder" value="{{ $subFolderId }}">
            <!-- Search Bar -->
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}"
                    class="mt-1 block w-full rounded-md border border-gray-300 py-2 pl-3 pr-10 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                    placeholder="Search...">
            </div>
            <div class="-mx-2 flex flex-wrap">
                <div class="w-full px-2 md:w-1/3">
                    <label for="state" class="block text-sm font-medium text-gray-700">State</label>
                    <select id="state" name="state_id"
                        class="mt-1 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                        <option value="">Select State</option>
                        @foreach ($states as $state)
                            <option value="{{ $state->id }}"
                                {{ request('state_id') == $state->id ? 'selected' : '' }}>
                                {{ $state->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="w-full px-2 md:w-1/3">
                    <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                    <select id="city" name="city_id"
                        class="mt-1 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                        <option value="">Select City</option>
                        @foreach ($cities as $city)
                            <option value="{{ $city->id }}" {{ request('city_id') == $city->id ? 'selected' : '' }}>
                                {{ $city->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="w-full px-2 md:w-1/3">
                    <label for="industry" class="block text-sm font-medium text-gray-700">Industry</label>
                    <input type="text" name="industry" id="industry" value="{{ request('industry') }}"
                        class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                        placeholder="Search Industry">
                </div>
            </div>

            <div>
                <button type="submit"
                    class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Filter</button>
            </div>
        </form>
            <!-- Export Button -->
            <button data-modal-target="#export-modal"
                class="mt-4 inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                Export Contact Lists
            </button>

            <!-- Export Modal with Date Range Picker and Additional Filters -->
            <div id="export-modal" class="fixed inset-0 z-10 flex items-center justify-center p-4" style="display:none;">
                <div class="bg-white rounded-lg shadow-lg max-w-md mx-auto p-6">
                    <h2 class="text-lg font-medium mb-4">Export Contact Lists</h2>
                    <p>Select filters to export the contact lists:</p>

                    <!-- Start Date -->
                    <div class="mt-4">
                        <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                        <input type="text" id="start_date" name="start_date" placeholder="Select Start Date"
                            class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                    </div>

                    <!-- End Date -->
                    <div class="mt-4">
                        <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                        <input type="text" id="end_date" name="end_date" placeholder="Select End Date"
                            class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                    </div>

                    <!-- Confirm and Cancel Buttons -->
                    <div class="mt-4">
                        <a href="#" id="confirm-export"
                            class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2" >
                            Confirm Export
                        </a>
                        <button type="button" class="ml-2 inline-flex items-center rounded-md border border-transparent bg-gray-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2"
                            onclick="document.getElementById('export-modal').style.display='none';">Cancel</button>
                    </div>
                </div>
            </div>

            <form action="{{ route('contactList.import') }}" method="POST" enctype="multipart/form-data">
                @csrf <!-- CSRF token for security -->
                <input type="hidden" name="subFolder" value="{{ $subFolderId }}"> <!-- Hidden input for subFolder ID -->
                <!-- File Input -->
                <div>
                    <label for="file">Upload File:</label>
                    <input type="file" name="file" id="file" accept=".xlsx,.csv" required>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="ml-2 inline-flex items-center rounded-md border border-transparent bg-gray-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    Import Contacts</button>
            </form>

        <div class="mt-6 divide-y rounded-lg bg-white shadow-sm overflow-x-auto">
            @if(request()->has('subfolder_id'))
                <h2 class="text-xl font-bold mb-4">Contacts for Subfolder ID: {{ request('subfolder_id') }}</h2>
            @endif
            <table class="min-w-full bg-white">
                <thead class="bg-gray-50">
                    <tr>
                        <th><input type="checkbox" id="select-all"></th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">Sub
                            Folder</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                            Created By</th>
                        <th class="hidden-column px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500" style="display: none;">
                            Status</th>
                        <th class="hidden-column px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500" style="display: none;">
                            Industry</th>
                        <th class="hidden-column px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500" style="display: none;">
                            Company</th>
                        <th class="hidden-column px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500" style="display: none;">
                            PIC</th>
                        <th class="hidden-column px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500" style="display: none;">
                            Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                            Contact 1</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                            Contact 2</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                            City</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                            State</th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                            Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @foreach ($contactLists as $contactList)
                        <tr>
                            <td><input type="checkbox" class="contact-checkbox" value="{{ $contactList->id }}"></td>
                            <td class="whitespace-nowrap px-6 py-4" >{{ $contactList->subFolder->name }}</td>
                            <td class="whitespace-nowrap px-6 py-4">{{ $contactList->user->name }}</td>
                            <td class="hidden-column whitespace-nowrap px-6 py-4" style="display: none;">{{ $contactList->status }}</td>
                            <td class="hidden-column whitespace-nowrap px-6 py-4" style="display: none;">{{ $contactList->industry }}</td>
                            <td class="hidden-column whitespace-nowrap px-6 py-4" style="display: none;">{{ $contactList->company }}</td>
                            <td class="hidden-column whitespace-nowrap px-6 py-4" style="display: none;">{{ $contactList->pic }}</td>
                            <td class="hidden-column whitespace-nowrap px-6 py-4" style="display: none;">{{ $contactList->email }}</td>
                            <td class="whitespace-nowrap px-6 py-4">{{ $contactList->contact1 }}</td>
                            <td class="whitespace-nowrap px-6 py-4">{{ $contactList->contact2 }}</td>
                            <td class="whitespace-nowrap px-6 py-4">{{ $contactList->city->name }}</td>
                            <td class="whitespace-nowrap px-6 py-4">{{ $contactList->state->name }}</td>
                            <td class="whitespace-nowrap px-6 py-4">
                                @if ($contactList->user->is(auth()->user()))
                                <x-dropdown>
                                    <x-slot name="trigger">
                                        <button>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                            </svg>
                                        </button>
                                    </x-slot>
                                    <x-slot name="content">
                                        <x-dropdown-link :href="route('contactList.edit', $contactList)">
                                            {{ __('Edit') }}
                                        </x-dropdown-link>
                                        <form method="POST" action="{{ route('contactList.destroy', $contactList) }}">
                                            @csrf
                                            @method('delete')
                                            <x-dropdown-link :href="route('contactList.destroy', $contactList)" onclick="event.preventDefault(); this.closest('form').submit();">
                                                {{ __('Delete') }}
                                            </x-dropdown-link>
                                        </form>
                                    </x-slot>
                                </x-dropdown>
                            @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <button id="toggle-columns"
                class="mt-4 inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                Show Less
            </button>
        </div>
        <div class="mt-4">
            {{ $contactLists->appends([
                'subFolder' => request()->query('subFolder'),
                'search' => request()->query('search'),
                'state_id' => request()->query('state_id'),
                'city_id' => request()->query('city_id'),
                'industry' => request()->query('industry')
            ])->links('pagination::tailwind') }}
        </div>
        <div id="mass-edit-form-container" class="hidden p-4 bg-white rounded-lg shadow-md max-w-sm mx-auto">
            <form id="mass-edit-form" method="POST" action="{{ route('contacts.mass_edit') }}">
                @csrf
                <input type="hidden" name="contact_ids" id="contact-ids">
                <h1 class="center">Mass Edit Form</h1>

                <div class="mb-4">
                    <label for="status" class="block text-gray-700">Status:</label>
                    <input type="text" name="status" id="status" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>
                <div class="mb-4">
                    <label for="company" class="block text-gray-700">Company:</label>
                    <input type="text" name="company" id="company" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>
                <div class="mb-4">
                    <label for="industry" class="block text-gray-700">Industry:</label>
                    <input type="text" name="industry" id="industry" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
                </div>
                <div class="mb-4">
                    <label for="state_id" class="block text-gray-700">State:</label>
                    <select id="state1" name="state_id" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
                    <option value="">Select State</option>
                    @foreach ($states as $state)
                    <option value="{{ $state->id }}"
                        {{ request('state_id') == $state->id ? 'selected' : '' }}>
                        {{ $state->name }}</option>
                    @endforeach
                </select>
                </div>
                <div class="mb-4">
                    <label for="city_id" class="block text-gray-700">City:</label>
                    <select id="city1" name="city_id"
                            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600">
                            <option value="">Select City</option>
                            @foreach ($cities as $city)
                            <option value="{{ $city->id }}" {{ request('city_id') == $city->id ? 'selected' : '' }}>
                                {{ $city->name }}</option>
                            @endforeach
                        </select>
                </div>
                <!-- Add other fields as needed -->

                <button type="submit" class="px-4 py-2 text-black bg-blue-600 rounded-lg hover:bg-blue-700">Mass Edit</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Function to handle state change and populate cities
            function handleStateChange(stateSelectId, citySelectId) {
                const stateSelect = document.getElementById(stateSelectId);
                const citySelect = document.getElementById(citySelectId);

                stateSelect.addEventListener('change', function() {
                    const stateId = stateSelect.value;

                    // Reset city selection
                    citySelect.value = '';

                    // Fetch cities for selected state
                    if (stateId) {
                        fetch(`/api/cities?state_id=${stateId}`)
                            .then(response => response.json())
                            .then(data => {
                                // Clear existing options
                                citySelect.innerHTML = '<option value="">Select City</option>';

                                // Populate new options
                                data.forEach(city => {
                                    const option = document.createElement('option');
                                    option.value = city.id;
                                    option.textContent = city.name;
                                    citySelect.appendChild(option);
                                });
                            })
                            .catch(error => console.error('Error fetching cities:', error));
                    } else {
                        // If no state is selected, reset city options
                        citySelect.innerHTML = '<option value="">Select City</option>';
                    }
                });
            }

            // Initialize the function for different state and city pairs
            handleStateChange('state', 'city');
            handleStateChange('state1', 'city1');
            handleStateChange('state2', 'city2');
        });
    </script>

    <script>
        document.getElementById('toggle-columns').addEventListener('click', function() {
            const columns = document.querySelectorAll('.hidden-column');
            const button = this;

            columns.forEach(column => {
                column.style.display = column.style.display === 'none' ? '' : 'none';
            });

            // Check if columns are currently visible
            const anyColumnVisible = Array.from(columns).some(column => column.style.display !== 'none');

            // Update button text based on column visibility
            button.textContent = anyColumnVisible ? 'Show Less' : 'Show More';
        });

        // Initial state (if columns are initially hidden)
        document.addEventListener('DOMContentLoaded', function() {
            const columns = document.querySelectorAll('.hidden-column');
            const button = document.getElementById('toggle-columns');

            const anyColumnVisible = Array.from(columns).some(column => column.style.display !== 'none');
            button.textContent = anyColumnVisible ? 'Show Less' : 'Show More';
        });

        // Show the modal when export button is clicked
        document.querySelector('[data-modal-target]').addEventListener('click', function() {
            var modalTarget = document.querySelector(this.getAttribute('data-modal-target'));
            if (modalTarget) {
                modalTarget.style.display = 'block';
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Function to get URL parameters
            function getQueryParam(name) {
                const params = new URLSearchParams(window.location.search);
                return params.get(name);
            }

            // Extract subFolderId from URL parameters
            const subFolderId = getQueryParam('subFolder');

            flatpickr('#start_date', {
                dateFormat: 'Y-m-d',
                defaultDate: new Date(),
            });

            flatpickr('#end_date', {
                dateFormat: 'Y-m-d',
                defaultDate: new Date(),
            });

            // Handle the export button click
            document.getElementById('confirm-export').addEventListener('click', function() {
                const startDate = document.getElementById('start_date').value;
                const endDate = document.getElementById('end_date').value;

                if (startDate && endDate) {
                    window.location.href = `/export-contact-lists?start_date=${startDate}&end_date=${endDate}&subfolder_id=${subFolderId}`;
                } else {
                    alert('Please select both start and end dates.');
                }
            });
        });

    </script>

        <script>
            // Function to handle checkbox changes and update the form
            function updateFormVisibility() {
                const selectedContacts = Array.from(document.querySelectorAll('.contact-checkbox:checked'));

                // Toggle the form visibility based on checkbox selection
                if (selectedContacts.length > 0) {
                    document.getElementById('mass-edit-form-container').classList.remove('hidden');
                    // Update the hidden input with the selected contact IDs
                    const contactIds = selectedContacts.map(cb => cb.value).join(',');
                    document.getElementById('contact-ids').value = contactIds;
                } else {
                    document.getElementById('mass-edit-form-container').classList.add('hidden');
                    document.getElementById('contact-ids').value = '';
                }
            }

            // Apply the updateFormVisibility function to each individual checkbox
            document.querySelectorAll('.contact-checkbox').forEach(function(checkbox) {
                checkbox.addEventListener('change', updateFormVisibility);
            });

            // Apply the updateFormVisibility function to the select-all checkbox
            document.getElementById('select-all').addEventListener('click', function() {
                const isChecked = this.checked;
                document.querySelectorAll('.contact-checkbox').forEach(function(checkbox) {
                    checkbox.checked = isChecked;
                });
                // Update the form visibility and hidden input based on the select-all state
                updateFormVisibility();
            });
        </script>
       {{--  <script>
            document.querySelectorAll('.contact-checkbox').forEach(function(checkbox) {
                checkbox.addEventListener('change', function() {
                    const selectedContacts = Array.from(document.querySelectorAll('.contact-checkbox:checked'));

                    // Toggle the form visibility based on checkbox selection
                    if (selectedContacts.length > 0) {
                        document.getElementById('mass-edit-form-container').classList.remove('hidden');
                        // Update the hidden input with the selected contact IDs
                        const contactIds = selectedContacts.map(cb => cb.value).join(',');
                        document.getElementById('contact-ids').value = contactIds;
                    } else {
                        document.getElementById('mass-edit-form-container').classList.add('hidden');
                        document.getElementById('contact-ids').value = '';
                    }
                });
            });
        </script> --}}

</x-app-layout>
