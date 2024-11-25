<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Contact List') }}
        </h2>
    </x-slot>
    <div class="mx-auto w-full max-w-full p-4 sm:p-6 md:max-w-3xl lg:max-w-5xl lg:p-8 xl:max-w-7xl">
        <button id="toggle-search-button"
                onclick="toggleSearchForm()"
                class="mb-4 inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                Search
        </button>
        {{-- Add Search Form & Export --}}
        <form action="{{ route('contactList.index') }}" method="get" class="mt-4 space-y-4">
            <!-- Hidden input for subFolder_id -->
            <input type="hidden" name="subFolder" value="{{ $subFolderId }}">
            <!-- Search Filters -->
            <div id="search-filters" class="hidden -mx-2 flex flex-wrap relative">
                <!-- Add all your input fields here as you have done previously -->
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

                <div class="w-full px-2 md:w-1/3">
                    <label for="resources" class="block text-sm font-medium text-gray-700">Resources</label>
                    <input type="text" name="resources" id="resources" value="{{ request('resources') }}"
                        class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                        placeholder="Search Resources">
                </div>

                <div class="w-full px-2 md:w-1/3">
                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                    <select id="status" name="status_id"
                        class="mt-1 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                        <option value="">Select Status</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status->id }}"
                                {{ request('status_id') == $status->id ? 'selected' : '' }}>
                                {{ $status->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="w-full px-2 md:w-1/3">
                    <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
                    <select id="type" name="type_id"
                        class="mt-1 block w-full rounded-md border border-gray-300 bg-white px-3 py-2 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                        <option value="">Select Type</option>
                        @foreach ($types as $type)
                            <option value="{{ $type->id }}"
                                {{ request('type_id') == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="w-full px-2 md:w-1/3">
                    <label for="company" class="block text-sm font-medium text-gray-700">Company</label>
                    <input type="text" name="company" id="company" value="{{ request('company') }}"
                        class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                        placeholder="Search Company">
                </div>

                <div class="w-full px-2 md:w-1/3">
                    <label for="product" class="block text-sm font-medium text-gray-700">Product</label>
                    <input type="text" name="product" id="product" value="{{ request('product') }}"
                        class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                        placeholder="Search Product">
                </div>

                <div class="w-full px-2 md:w-1/3">
                    <label for="bgoc_product" class="block text-sm font-medium text-gray-700">BGOC Product</label>
                    <input type="text" name="bgoc_product" id="bgoc_product" value="{{ request('bgoc_product') }}"
                        class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                        placeholder="Search BGOC Product">
                </div>

                <div class="w-full px-2 md:w-1/3">
                    <label for="contact1" class="block text-sm font-medium text-gray-700">contact1</label>
                    <input type="text" name="contact1" id="contact1" value="{{ request('contact1') }}"
                        class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                        placeholder="Search contact1">
                </div>

                <div class="w-full px-2 md:w-1/3">
                    <label for="contact2" class="block text-sm font-medium text-gray-700">contact2</label>
                    <input type="text" name="contact2" id="contact2" value="{{ request('contact2') }}"
                        class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                        placeholder="Search Contact2">
                </div>

                <div class="w-full px-2 md:w-1/3">
                    <label for="pic" class="block text-sm font-medium text-gray-700">PIC</label>
                    <input type="text" name="pic" id="pic" value="{{ request('pic') }}"
                        class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                        placeholder="Search PIC">
                </div>

                <div class="w-full px-2 md:w-1/3">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="text" name="email" id="email" value="{{ request('email') }}"
                        class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                        placeholder="Search email">
                </div>

                <div class="w-full px-2 md:w-1/3">
                    <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                    <input type="text" name="address" id="address" value="{{ request('address') }}"
                        class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                        placeholder="Search Address">
                </div>

                <div class="w-full flex justify-start mt-4">
                    <button type="submit"
                        class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Filter</button>
                </div>
                <!-- Close Button -->
                <button id="close-filter-button"
                    onclick="closeSearchForm()"
                    class="mb-4 inline-flex items-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                Close Filter
                </button>
            </div>
            <!-- End Filters -->


            <!-- Export Button -->
            <button type="button" data-modal-target="#export-modal"
                class="mt-4 inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                Export Contact Lists
            </button>

            <!-- Export Modal -->
            <div id="export-modal" class="fixed inset-0 z-10 flex items-center justify-center p-4"
                style="display:none;">
                <div class="mx-auto max-w-md rounded-lg bg-white p-6 shadow-lg">
                    <h2 class="mb-4 text-lg font-medium">Export Contact Lists</h2>
                    <p>Select filters to export the contact lists:</p>

                    <!-- Keep the export form fields here -->
                    <div class="mt-4">
                        <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                        <input type="text" id="start_date" name="start_date" placeholder="Select Start Date"
                            class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                    </div>

                    <div class="mt-4">
                        <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                        <input type="text" id="end_date" name="end_date" placeholder="Select End Date"
                            class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                    </div>

                    <!-- Confirm and Cancel Buttons -->
                    <div class="mt-4">
                        <button type="submit" formaction="/export-contact-lists"
                            class="inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                            Confirm Export
                        </button>
                        <button type="button"
                            class="ml-2 inline-flex items-center rounded-md border border-transparent bg-gray-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2"
                            onclick="document.getElementById('export-modal').style.display='none';">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </form>

        <form action="{{ route('contactList.import') }}" method="POST" enctype="multipart/form-data">
            @csrf <!-- CSRF token for security -->
            <input type="hidden" name="subFolder" value="{{ $subFolderId }}">
            <!-- Hidden input for subFolder ID -->
            <!-- File Input -->
            <div>
                <label for="file">Upload File:</label>
                <input type="file" name="file" id="file" accept=".xlsx,.csv" required>
            </div>

            <!-- Submit Button -->
            <button type="submit"
                class="ml-2 inline-flex items-center rounded-md border border-transparent bg-gray-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                Import Contacts</button>
        </form>

        <div class="mt-6 divide-y overflow-x-auto rounded-lg bg-white shadow-sm">
            @if (request()->has('subfolder_id'))
                <h2 class="mb-4 text-xl font-bold">Contacts for Subfolder ID: {{ request('subfolder_id') }}</h2>
            @endif

            <table class="min-w-full bg-white">
                <div id="action-buttons" class="mb-4 flex hidden gap-2">
                    <button id="edit-button"
                        class="rounded-lg bg-green-600 px-4 py-2 text-white hover:bg-green-700">Edit</button>
                    <button id="delete-button"
                        class="rounded-lg bg-red-600 px-4 py-2 text-white hover:bg-red-700">Delete</button>
                </div>
                <input type="hidden" name="subFolder" value="{{ $subFolderId }}">
                <thead class="bg-gray-50">
                    <tr>
                        <th><input type="checkbox" id="select-all">

                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                            Date Created
                        </th>
                        <th class="hidden-column px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500"
                            style="display: none;">
                            Sub Folder
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                            Created By
                        </th>
                        <th class="hidden-column px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500"
                            style="display: none;">
                            Resources
                        </th>
                        <th class="hidden-column px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500"
                            style="display: none;">
                            Status
                        </th>
                        <th class="hidden-column px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500"
                            style="display: none;">
                            Type
                        </th>
                        <th class="hidden-column px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500"
                            style="display: none;">
                            Industry
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                            Company
                        </th>
                        <th class="hidden-column px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500"
                            style="display: none;">
                            Product
                        </th>
                        <th class="hidden-column px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500"
                            style="display: none;">
                            Bgoc Product
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                            PIC
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                            Email
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                            Contact 1
                        </th>
                        <th class="hidden-column px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500"
                            style="display: none;">
                            Contact 2
                        </th>
                        <th class="hidden-column px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500"
                            style="display: none;">
                            Address
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                            City
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                            State
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                            Remarks
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                    @foreach ($contactLists as $contactList)
                        <tr>
                            <td><input type="checkbox" class="contact-checkbox" value="{{ $contactList->id }}"></td>
                            <td class="whitespace-nowrap px-6 py-4">{{ $contactList->created_at->format('Y-m-d') }}
                            </td>
                            <td class="hidden-column whitespace-nowrap px-6 py-4" style="display: none;">
                                {{ $contactList->subFolder->name }}</td>
                            <td class="whitespace-nowrap px-6 py-4">{{ $contactList->user->name }}</td>
                            <td class="hidden-column whitespace-nowrap px-6 py-4" style="display: none;">
                                {{ $contactList->resources }}</td>
                            <td class="hidden-column whitespace-nowrap px-6 py-4" style="display: none;">
                                {{ $contactList->status->name }}</td>
                            <td class="hidden-column whitespace-nowrap px-6 py-4" style="display: none;">
                                {{ $contactList->type->name }}</td>
                            <td class="hidden-column whitespace-nowrap px-6 py-4" style="display: none;">
                                {{ $contactList->industry }}</td>
                            <td class="whitespace-nowrap px-6 py-4">{{ $contactList->company }}</td>
                            <td class="hidden-column whitespace-nowrap px-6 py-4" style="display: none;">
                                {{ $contactList->product }}</td>
                            <td class="hidden-column whitespace-nowrap px-6 py-4" style="display: none;">
                                {{ $contactList->bgoc_product }}</td>
                            <td class="whitespace-nowrap px-6 py-4">{{ $contactList->pic }}</td>
                            <td class="whitespace-nowrap px-6 py-4">{{ $contactList->email }}</td>
                            <td class="whitespace-nowrap px-6 py-4">{{ $contactList->contact1 }}</td>
                            <td class="hidden-column whitespace-nowrap px-6 py-4" style="display: none;">
                                {{ $contactList->contact2 }}</td>
                            <td class="hidden-column whitespace-nowrap px-6 py-4" style="display: none;">
                                {{ $contactList->address }}</td>
                            <td class="whitespace-nowrap px-6 py-4">{{ $contactList->city->name }}</td>
                            <td class="whitespace-nowrap px-6 py-4">{{ $contactList->state->name }}</td>
                            <td class="whitespace-nowrap px-6 py-4">{{ $contactList->remarks }}</td>
                            <td class="whitespace-nowrap px-6 py-4">
                                @if ($contactList->user->is(auth()->user()))
                                    <x-dropdown>
                                        <x-slot name="trigger">
                                            <button>
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400"
                                                    viewBox="0 0 20 20" fill="currentColor">
                                                    <path
                                                        d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                                </svg>
                                            </button>
                                        </x-slot>
                                        <x-slot name="content">
                                            <x-dropdown-link :href="route('contactList.edit', ['contactList' => $contactList->id]) . '?subFolder=' . $subFolderId">
                                        {{ __('Edit') }}
                                    </x-dropdown-link>

                                    <form method="POST" action="{{ route('contactList.destroy', $contactList) }}">
                                        @csrf
                                        @method('delete')
                                        <input type="hidden" name="subFolderId" value="{{ $subFolderId }}">
                                        <x-dropdown-link :href="route('contactList.destroy', $contactList)"
                                                onclick="event.preventDefault(); this.closest('form').submit();">
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
                    'status_id' => request()->query('status_id'),
                    'type_id' => request()->query('type_id'),
                    'company' => request()->query('company'),
                    'product' => request()->query('product'),
                    'industry' => request()->query('industry'),
                    'contact1' => request()->query('contact1'),
                    'contact2' => request()->query('contact2'),
                    'pic' => request()->query('pic'),
                    'email' => request()->query('email'),
                    'address' => request()->query('address'),
                ])->links('pagination::tailwind') }}
        </div>

        <div id="mass-edit-form-container"
            class="fixed inset-0 z-50 flex hidden items-center justify-center bg-black bg-opacity-50">
            <div class="relative w-full max-w-sm rounded-lg bg-white p-6 shadow-lg">
                <!-- Close Button -->
                <button id="closeMassEditForm" class="absolute right-4 top-4 text-gray-500 hover:text-gray-700">
                    &times;
                </button>
                <form id="mass-edit-form" method="POST" action="{{ route('contacts.mass_edit') }}">
                    @csrf
                    <input type="hidden" name="contact_ids" id="contact-ids">
                    <h1 class="text-lg font-semibold text-center mb-3">Mass Edit Form</h1>

                    <div class="grid grid-cols-1 gap-2">
                        <div>
                            <label for="resources" class="block text-gray-700 text-xs">Resources:</label>
                            <input type="text" name="resources" id="resources"
                                class="w-full rounded-lg border px-2 py-1 focus:outline-none focus:ring-2 focus:ring-blue-600">
                        </div>
                        <div>
                            <label for="status_id" class="block text-gray-700 text-xs">Status:</label>
                            <select id="status_id" name="status_id"
                                class="w-full rounded-lg border px-2 py-1 focus:outline-none focus:ring-2 focus:ring-blue-600">
                                <option value="">-- Select Status --</option>
                                @foreach ($statuses as $status)
                                    @if (!empty($status) && isset($status->id))
                                        <option value="{{ $status->id }}">{{ $status->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="type_id" class="block text-gray-700 text-xs">Type:</label>
                            <select id="type_id" name="type_id"
                                class="w-full rounded-lg border px-2 py-1 focus:outline-none focus:ring-2 focus:ring-blue-600">
                                <option value="">-- Select Type --</option>
                                @foreach ($types as $type)
                                    @if (!empty($type) && isset($type->id))
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="industry" class="block text-gray-700 text-xs">Industry:</label>
                            <input type="text" name="industry" id="industry"
                                class="w-full rounded-lg border px-2 py-1 focus:outline-none focus:ring-2 focus:ring-blue-600">
                        </div>
                        <div>
                            <label for="company" class="block text-gray-700 text-xs">Company:</label>
                            <input type="text" name="company" id="company"
                                class="w-full rounded-lg border px-2 py-1 focus:outline-none focus:ring-2 focus:ring-blue-600">
                        </div>
                        <div>
                            <label for="product" class="block text-gray-700 text-xs">Product:</label>
                            <input type="text" name="product" id="product"
                                class="w-full rounded-lg border px-2 py-1 focus:outline-none focus:ring-2 focus:ring-blue-600">
                        </div>
                        <div>
                            <label for="bgoc_product" class="block text-gray-700 text-xs">BGOC Product:</label>
                            <input type="text" name="bgoc_product" id="bgoc_product"
                                class="w-full rounded-lg border px-2 py-1 focus:outline-none focus:ring-2 focus:ring-blue-600">
                        </div>
                        <div>
                            <label for="pic" class="block text-gray-700 text-xs">PIC:</label>
                            <input type="pic" name="pic" id="pic"
                                class="w-full rounded-lg border px-2 py-1 focus:outline-none focus:ring-2 focus:ring-blue-600">
                        </div>
                        <div>
                            <label for="address" class="block text-gray-700 text-xs">Address:</label>
                            <input type="text" name="address" id="address"
                                class="w-full rounded-lg border px-2 py-1 focus:outline-none focus:ring-2 focus:ring-blue-600">
                        </div>
                        <div>
                            <label for="state_id" class="block text-gray-700 text-xs">State:</label>
                            <select id="state1" name="state_id"
                                class="w-full rounded-lg border px-2 py-1 focus:outline-none focus:ring-2 focus:ring-blue-600">
                                <option value="">Select State</option>
                                @foreach ($states as $state)
                                    <option value="{{ $state->id }}" {{ request('state_id') == $state->id ? 'selected' : '' }}>
                                        {{ $state->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="city_id" class="block text-gray-700 text-xs">City:</label>
                            <select id="city1" name="city_id"
                                class="w-full rounded-lg border px-2 py-1 focus:outline-none focus:ring-2 focus:ring-blue-600">
                                <option value="">Select City</option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}" {{ request('city_id') == $city->id ? 'selected' : '' }}>
                                        {{ $city->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="mt-3 rounded-lg bg-blue-600 px-3 py-1 text-white hover:bg-blue-700">Mass Edit</button>
                </form>
            </div>
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
            flatpickr('#start_date', {
                dateFormat: 'Y-m-d',
                defaultDate: new Date(),
            });

            flatpickr('#end_date', {
                dateFormat: 'Y-m-d',
                defaultDate: new Date(),
            });

            // Check if the confirm-export button exists before adding an event listener
            const exportButton = document.getElementById('export-form');
            if (exportButton) {
                exportButton.addEventListener('submit', function(event) {
                    const startDate = document.getElementById('start_date').value;
                    const endDate = document.getElementById('end_date').value;

                    // Assuming you have an input field with the subFolderId
                    const subFolderId = document.getElementById('subFolderId').value;

                    // Log values to the console
                    console.log('Start Date:', startDate);
                    console.log('End Date:', endDate);
                    console.log('SubFolderId:', subFolderId);

                    // Check if both dates are selected before proceeding
                    if (startDate && endDate) {
                        // Log the full URL that will be requested
                        console.log(
                            `Export URL: /export-contact-lists?start_date=${startDate}&end_date=${endDate}&subFolderId=${subFolderId}`
                        );

                        // Trigger the export by updating the URL
                        window.location.href =
                            `/export-contact-lists?start_date=${startDate}&end_date=${endDate}&subFolderId=${subFolderId}`;
                    } else {
                        alert('Please select both start and end dates.');
                    }
                });
            } else {
                console.error('Export button with ID "confirm-export" not found.');
            }
        });
    </script>

    <script>
        // Function to handle checkbox changes and update button visibility
        function updateActionButtonVisibility() {
            const selectedContacts = Array.from(document.querySelectorAll('.contact-checkbox:checked'));
            const actionButtons = document.getElementById('action-buttons');

            // Toggle the action buttons visibility based on checkbox selection
            if (selectedContacts.length > 0) {
                actionButtons.classList.remove('hidden');
                // Update the hidden input with the selected contact IDs
                const contactIds = selectedContacts.map(cb => cb.value).join(',');
                document.getElementById('contact-ids').value = contactIds;
            } else {
                actionButtons.classList.add('hidden');
                document.getElementById('contact-ids').value = '';
            }
        }

        // Show the mass edit form when the "Edit" button is clicked
        document.getElementById('edit-button').addEventListener('click', function() {
            document.getElementById('mass-edit-form-container').classList.remove('hidden');
            document.getElementById('action-buttons').classList.add('hidden'); // Hide action buttons
        });

        // Apply the updateActionButtonVisibility function to each individual checkbox
        document.querySelectorAll('.contact-checkbox').forEach(function(checkbox) {
            checkbox.addEventListener('change', updateActionButtonVisibility);
        });

        // Apply the updateActionButtonVisibility function to the select-all checkbox
        document.getElementById('select-all').addEventListener('click', function() {
            const isChecked = this.checked;
            document.querySelectorAll('.contact-checkbox').forEach(function(checkbox) {
                checkbox.checked = isChecked;
            });
            // Update the form visibility and hidden input based on the select-all state
            updateActionButtonVisibility();
        });

        // Hide the modal when the close button is clicked
        document.getElementById('closeMassEditForm').addEventListener('click', function() {
            document.getElementById('mass-edit-form-container').classList.add('hidden');
        });

         // Function to handle delete action
         document.addEventListener('DOMContentLoaded', function () {
            const deleteButton = document.getElementById('delete-button');
            if (deleteButton) {
                deleteButton.addEventListener('click', function () {
                    const selectedContacts = Array.from(document.querySelectorAll('.contact-checkbox:checked'));

                    if (selectedContacts.length === 0) {
                        alert('Please select at least one contact to delete.');
                        return;
                    }

                    if (!confirm('Are you sure you want to delete the selected contacts?')) {
                        return;
                    }

                    const contactIds = selectedContacts.map(cb => cb.value);
                    const subFolderId = document.getElementById('sub-folder-id')?.value;

                    fetch(`/contact-list/delete-multiple`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            contactIds: contactIds,
                            subFolderId: subFolderId
                        })
                    })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Failed to delete contacts.');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                alert('Contacts deleted successfully.');
                                selectedContacts.forEach(cb => cb.closest('tr').remove());
                                updateActionButtonVisibility();
                            } else {
                                alert(data.message || 'An error occurred while deleting the contacts.');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('An error occurred while deleting the contacts.');
                        });
                });
            } else {
                console.error('Delete button not found in the DOM.');
            }
        });
    </script>
    <script>
        function toggleSearchForm() {
            // Hide the Search button
            document.getElementById("toggle-search-button").style.display = "none";

            // Show the search filters form
            const searchFilters = document.getElementById("search-filters");
            searchFilters.classList.remove("hidden");
            searchFilters.style.display = "flex";  // Ensure the div uses flex display
        }
        function closeSearchForm() {
            // Hide the search filters form
            const searchFilters = document.getElementById("search-filters");
            searchFilters.classList.add("hidden");

            // Show the Search button again
            document.getElementById("toggle-search-button").style.display = "inline-flex"; // Show the button
        }
    </script>
    <script>


    </script>
</x-app-layout>
