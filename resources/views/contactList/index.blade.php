<x-layout>

    <x-navbars.sidebar activePage="{{ $subFolderId ? 'none' : 'contactList' }}"></x-navbars.sidebar>

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <style>
        /* The modal background overlay */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Semi-transparent black for dimming */
            backdrop-filter: blur(5px); /* Apply a blur effect to the background */
            z-index: 999; /* Ensure it stays above content */
            display: none; /* Hidden by default, will be shown when modal is open */
        }

        /* Modal content */
        .modal-content {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            width: 80%; /* You can adjust the width as needed */
            max-width: 600px; /* Max width to prevent too large modals */
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            display: block;
        }

        /* Close button */
        .close-button {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 24px;
            background: none;
            border: none;
            color: #333;
            cursor: pointer;
        }

        /* Modal title */
        .modal-title {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 15px;
        }

        /* General Form Styles */
        .form-container {
            margin-top: 1rem;
        }

        .search-filters {
            display: none;
            flex-wrap: wrap;
            position: relative;
            column-gap: 6px
        }

        .w-full md:w-1/4 {
            width: 100%;
            padding-left: 0.5rem;
            padding-right: 0.5rem;
            margin-bottom: 1rem;
        }

        .label {
            font-size: 0.875rem;
            font-weight: 500;
            color: #4A5568; /* Text gray-700 */
            display: block;
            margin-bottom: 0.25rem;
        }

        .input-field {
            width: 100%;
            padding: 0.5rem 0.75rem;
            border: 1px solid #CBD5E0; /* Border gray-300 */
            border-radius: 0.375rem;
            background-color: #FFFFFF;
            font-size: 0.875rem;
            transition: border-color 0.2s;
        }

        .input-field:focus {
            border-color: #6366F1; /* Border indigo-500 */
            outline: none;
            box-shadow: 0 0 0 2px rgba(99, 102, 241, 0.5); /* Focus ring */
        }

        .button-group {
            display: flex;
            justify-content: flex-start;
            margin-top: 1rem;
        }

        .btn-primary {
            background-color: #4F46E5; /* Indigo-600 */
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            border: none;
            font-size: 0.875rem;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .btn-primary:hover {
            background-color: #4338CA; /* Hover Indigo-700 */
        }

        .btn-danger {
            background-color: #E11D48; /* Red-600 */
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            border: none;
            font-size: 0.875rem;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .btn-danger:hover {
            background-color: #9B1C29; /* Hover Red-700 */
        }

        .btn-cancel {
            background-color: #4B5563; /* Gray-600 */
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            border: none;
            font-size: 0.875rem;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .btn-cancel:hover {
            background-color: #374151; /* Hover Gray-700 */
        }

        /* Modal Styles */
        .export-modal {
            position: fixed;
            inset: 0;
            z-index: 10;
            display: none;
            justify-content: center;
            align-items: center;
            padding: 1rem;
        }

        .modal-content {
            background-color: white;
            padding: 1.5rem;
            border-radius: 0.375rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 28rem;
            width: 100%;
        }

        .modal-title {
            font-size: 1.125rem;
            font-weight: 500;
            margin-bottom: 1rem;
        }

        .padds {
            padding-left: 0.9rem
        }

        .paddss {
            padding-left: 3rem
        }

        .round{
            border-radius: 1rem
        }

        table {
            border: 2px solid #000; /* Solid black border around the table */
            border-radius: 10px; /* Adjust the value to control the curvature */
            overflow: hidden;    /* Ensures that the content doesn't overflow the rounded corners */
        }

        table th, table td {
            height: 50px;  /* Set fixed height for each cell */
            white-space: normal !important;
        }

        .reoutline {
           border: transparent;
           background: transparent;
           font: 600;
        }
        #myTable th:nth-child(15) { /* First column header */
            min-width: 350px;
        }
        #myTable th:nth-child(2),
        #myTable th:nth-child(3),
        #myTable th:nth-child(6),
        #myTable th:nth-child(7),
        #myTable th:nth-child(8),
        #myTable th:nth-child(10),
        #myTable th:nth-child(11),
        #myTable th:nth-child(16) {
            min-width: 140px;
        }

        .flexin{
            display: flex;
            margin-bottom: -60px;
        }

    </style>

    <x-navbars.navs.auth titlePage="{{ $subFolderId ? 'Contact List' : 'All Contact List' }}"></x-navbars.navs.auth>

        @if ($subFolderId)
        <h5>{{ \App\Models\SubFolder::find($subFolderId)->name }}</h5>
        @endif

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 pb-7">
        <button id="toggle-search-button"
                onclick="toggleSearchForm()"
                class="btn bg-gradient-dark">
                Search
        </button>
        @if ($subFolderId)
        <button
            class="btn bg-gradient-dark"
            onclick="window.location.href='{{ route('contactList.create', ['subFolder' => $subFolderId]) }}'">
            Add Contact
        </button>
        @endif
        {{-- Add Search Form & Export --}}
        <form action="{{ route('contactList.index') }}" method="get" class="form-container">
            <!-- Hidden input for subFolder_id -->
            <input type="hidden" name="subFolder" value="{{ $subFolderId }}">
            <!-- Search Filters -->
            <div id="search-filters" class="hidden search-filters">

                <div class="w-full flex justify-start mt-4">
                    <button type="submit"
                        class="btn bg-gradient-dark">Filter</button>

                <!-- Close Button -->
                    <button id="close-filter-button"
                        onclick="closeSearchForm()"
                        class="btn btn-danger btn-link">
                        Close Filter
                    </button>
                </div>

                <!-- Add all your input fields here as you have done previously -->
                <div class="w-full md:w-1/4">
                    <label for="state" class="label">State</label>
                    <select id="state" name="state_id"
                        class="input-field">
                        <option value="">Select State</option>
                        @foreach ($states as $state)
                            <option value="{{ $state->id }}"
                                {{ request('state_id') == $state->id ? 'selected' : '' }}>
                                {{ $state->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="w-full md:w-1/4">
                    <label for="city" class="label">City</label>
                    <select id="city" name="city_id"
                        class="input-field">
                        <option value="">Select City</option>
                        @foreach ($cities as $city)
                            <option value="{{ $city->id }}" {{ request('city_id') == $city->id ? 'selected' : '' }}>
                                {{ $city->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="w-full md:w-1/4">
                    <label for="industry" class="label">Industry</label>
                    <input type="text" name="industry" id="industry" value="{{ request('industry') }}"
                        class="input-field"
                        placeholder="Search Industry">
                </div>

                <div class="w-full md:w-1/4">
                    <label for="resources" class="label">Resources</label>
                    <input type="text" name="resources" id="resources" value="{{ request('resources') }}"
                        class="input-field"
                        placeholder="Search Resources">
                </div>

                <div class="w-full md:w-1/4">
                    <label for="status" class="label">Status</label>
                    <select id="status" name="status_id"
                        class="input-field">
                        <option value="">Select Status</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status->id }}"
                                {{ request('status_id') == $status->id ? 'selected' : '' }}>
                                {{ $status->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="w-full md:w-1/4">
                    <label for="type" class="label">Type</label>
                    <select id="type" name="type_id"
                        class="input-field">
                        <option value="">Select Type</option>
                        @foreach ($types as $type)
                            <option value="{{ $type->id }}"
                                {{ request('type_id') == $type->id ? 'selected' : '' }}>
                                {{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="w-full md:w-1/4">
                    <label for="company" class="label">Company</label>
                    <input type="text" name="company" id="company" value="{{ request('company') }}"
                        class="input-field"
                        placeholder="Search Company">
                </div>

                <div class="w-full md:w-1/4">
                    <label for="product" class="label">Product</label>
                    <input type="text" name="product" id="product" value="{{ request('product') }}"
                        class="input-field"
                        placeholder="Search Product">
                </div>

                <div class="w-full md:w-1/4">
                    <label for="bgoc_product" class="label">BGOC Product</label>
                    <input type="text" name="bgoc_product" id="bgoc_product" value="{{ request('bgoc_product') }}"
                        class="input-field"
                        placeholder="Search BGOC Product">
                </div>

                <div class="w-full md:w-1/4">
                    <label for="contact1" class="label">contact1</label>
                    <input type="text" name="contact1" id="contact1" value="{{ request('contact1') }}"
                        class="input-field"
                        placeholder="Search contact1">
                </div>

                <div class="w-full md:w-1/4">
                    <label for="contact2" class="label">contact2</label>
                    <input type="text" name="contact2" id="contact2" value="{{ request('contact2') }}"
                        class="input-field"
                        placeholder="Search Contact2">
                </div>

                <div class="w-full md:w-1/4">
                    <label for="pic" class="label">PIC</label>
                    <input type="text" name="pic" id="pic" value="{{ request('pic') }}"
                        class="input-field"
                        placeholder="Search PIC">
                </div>

                <div class="w-full md:w-1/4">
                    <label for="email" class="label">Email</label>
                    <input type="text" name="email" id="email" value="{{ request('email') }}"
                        class="input-field"
                        placeholder="Search email">
                </div>

                <div class="w-full md:w-1/4">
                    <label for="address" class="label">Address</label>
                    <input type="text" name="address" id="address" value="{{ request('address') }}"
                        class="input-field"
                        placeholder="Search Address">
                </div>

            </div>
            <!-- End Filters -->


            <!-- Export Button -->
            <button type="button" data-modal-target="#export-modal"
                class="btn bg-gradient-dark">
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
                        <label for="start_date" class="label">Start Date</label>
                        <input type="date" id="start_date" name="start_date"
                            class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                    </div>

                    <div class="mt-4">
                        <label for="end_date" class="label">End Date</label>
                        <input type="date" id="end_date" name="end_date"
                            class="mt-1 block w-full rounded-md border border-gray-300 px-3 py-2 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm">
                    </div>

                    <!-- Confirm and Cancel Buttons -->
                    <div class="mt-4">
                        <button type="submit" formaction="/export-contact-lists"
                            class="btn bg-gradient-dark">
                            Confirm Export
                        </button>
                        <button type="button"
                            class="btn btn-danger btn-link"
                            onclick="document.getElementById('export-modal').style.display='none';">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
        </form>
        @if ($subFolderId)
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
                class="btn bg-gradient-dark">
                Import Contacts
            </button>
            <!-- Button to download the empty Excel template -->
            <a href="{{ route('contactList.downloadTemplate') }}" class="btn bg-gradient-dark">Download Template</a>

        </form>
        @endif
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="overflow-x-auto round px-5">
                @if (request()->has('subfolder_id'))
                    <h2 class="text-xl font-bold">Contacts for Subfolder ID: {{ request('subfolder_id') }}</h2>
                @endif

                <table id="myTable" class="display min-w-full border-collapse border border-gray-300 round">
                    <div id="action-buttons" class="p-2 gap-2" style="display: none">
                            <div class="flexin gap-2">
                                <button id="edit-button"
                                class="btn btn-success btn-link">Edit</button>
                                <form id="delete-form" action="{{ route('contacts.deleteMultiple') }}" method="POST" style="display: none;">
                                    @csrf
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" id="delete_contact_ids" name="contact_ids">
                                    <button type="submit" id="delete-button" class="btn btn-danger btn-link">Delete</button>
                                </form>
                            </div>
                    </div>
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="select-all-checkbox"></th>
                            <th class="py-2 px-4 border-b border-gray-300 text-gray-600 font-bold text-center">Date Created</th>
                            <th class="hidden-column py-2 px-4 border-b border-gray-300 text-center text-gray-600 font-bold" style="display: none;">Sub Folder</th>
                            {{-- <th class="py-2 px-4 border-b border-gray-300 text-center text-gray-600 font-bold" style="display: none;">Created By</th> --}}
                            <th class="hidden-column py-2 px-4 border-b border-gray-300 text-center text-gray-600 font-bold"style="display: none;">Resources</th>
                            <th class="hidden-column py-2 px-4 border-b border-gray-300 text-center text-gray-600 font-bold"style="display: none;">Status</th>
                            <th class="py-2 px-4 border-b border-gray-300 text-center text-gray-600 font-bold">Type</th>
                            <th class="py-2 px-4 border-b border-gray-300 text-center text-gray-600 font-bold">Industry</th>
                            <th class="py-2 px-4 border-b border-gray-300 text-center text-gray-600 font-bold">Company</th>
                            <th class="hidden-column py-2 px-4 border-b border-gray-300 text-center text-gray-600 font-bold"style="display: none;">Product</th>
                            <th class="hidden-column py-2 px-4 border-b border-gray-300 text-center text-gray-600 font-bold"style="display: none;">Bgoc Product</th>
                            <th class="py-2 px-4 border-b border-gray-300 text-center text-gray-600 font-bold">PIC</th>
                            <th class="py-2 px-4 border-b border-gray-300 text-center text-gray-600 font-bold">Email</th>
                            <th class="py-2 px-4 border-b border-gray-300 text-center text-gray-600 font-bold">Contact 1</th>
                            <th class="hidden-column py-2 px-4 border-b border-gray-300 text-center text-gray-600 font-bold"style="display: none;">Contact 2</th>
                            <th class="hidden-column py-2 px-4 border-b border-gray-300 text-center text-gray-600 font-bold"style="display: none;">Address</th>
                            <th class="py-2 px-4 border-b border-gray-300 text-center text-gray-600 font-bold">City</th>
                            <th class="py-2 px-4 border-b border-gray-300 text-center text-gray-600 font-bold">State</th>
                            <th class="py-2 px-4 border-b border-gray-300 text-center text-gray-600 font-bold">Remarks</th>
                            <th class="py-2 px-4 border-b border-gray-300 text-center text-gray-600 font-bold">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($contactLists as $contactList)
                            <tr>
                                <td><input type="checkbox" class="contact-checkbox" value="{{ $contactList->id }}"></td>
                                <td class="py-2 px-4 border-b border-gray-300 text-center">{{ $contactList->created_at->format('Y-m-d') }}</td>
                                <td class="hidden-column py-2 px-4 border-b border-gray-300 text-center" style="display: none;">{{ $contactList->subFolder->name }}</td>
                                {{-- <td class="hidden-column py-2 px-4 border-b border-gray-300 text-center" style="display: none;">{{ $contactList->user->name }}</td> --}}
                                <td class="hidden-column py-2 px-4 border-b border-gray-300 text-center" style="display: none;">{{ $contactList->resources }}</td>
                                <td class="hidden-column py-2 px-4 border-b border-gray-300 text-center" style="display: none;">{{ $contactList->status->name }}</td>
                                <td class="py-2 px-4 border-b border-gray-300 text-center">{{ $contactList->type->name }}</td>
                                <td class="py-2 px-4 border-b border-gray-300 text-center">{{ $contactList->industry }}</td>
                                <td class="py-2 px-4 border-b border-gray-300 text-center">{{ $contactList->company }}</td>
                                <td class="hidden-column py-2 px-4 border-b border-gray-300 text-center" style="display: none;">{{ $contactList->product }}</td>
                                <td class="hidden-column py-2 px-4 border-b border-gray-300 text-center" style="display: none;">{{ $contactList->bgoc_product }}</td>
                                <td class="py-2 px-4 border-b border-gray-300 text-center">{{ $contactList->pic }}</td>
                                <td class="py-2 px-4 border-b border-gray-300 text-center">{{ $contactList->email }}</td>
                                <td class="py-2 px-4 border-b border-gray-300 text-center">{{ $contactList->contact1 }}</td>
                                <td class="hidden-column py-2 px-4 border-b border-gray-300 text-center" style="display: none;">{{ $contactList->contact2 }}</td>
                                <td class="hidden-column py-2 px-4 border-b border-gray-300 text-center" style="display: none;">{{ $contactList->address }}</td>
                                <td class="py-2 px-4 border-b border-gray-300 text-center">{{ $contactList->city->name }}</td>
                                <td class="py-2 px-4 border-b border-gray-300 text-center">{{ $contactList->state->name }}</td>
                                <td class="py-2 px-4 border-b border-gray-300 text-center">{{ $contactList->remarks }}</td>
                                <td class="py-2 px-4 border-b border-gray-300 text-center">
                                    @if ($contactList->user->is(auth()->user()))
                                    <div class="dropdown">
                                        <button class="reoutline" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-30 w-30" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                            </svg>
                                        </button>
                                        <ul class="dropdown-menu bg-white shadow-md rounded-lg border border-gray-300 absolute left-0 top-full mt-1 overflow-visible">
                                            <!-- Edit Link -->
                                            <li>
                                                <a class="dropdown-item" href="{{ route('contactList.edit', ['contactList' => $contactList->id]) . '?subFolder=' . $subFolderId }}">
                                                    {{ __('Edit') }}
                                                </a>
                                            </li>

                                            <!-- Delete Form -->
                                            <li>
                                                <form method="POST" action="{{ route('contactList.destroy', $contactList) }}">
                                                    @csrf
                                                    @method('delete')
                                                    <input type="hidden" name="subFolderId" value="{{ $subFolderId }}">
                                                    <a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); this.closest('form').submit();">
                                                        {{ __('Delete') }}
                                                    </a>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <button id="toggle-columns"
                    class="btn bg-gradient-dark mb-0">
                    Show Less
                </button>
            </div>
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
                ])->links() }}
        </div>

        <div class="modal-overlay" id="modal-overlay"></div>

        <div id="mass-edit-form-container" class="modal" style="display: none;">

                <div class="modal-content">
                <!-- Close Button -->
                <button id="closeMassEditForm" class="absolute right-4 top-4 text-gray-500 hover:text-gray-700">
                    &times;
                </button>
                <form id="mass-edit-form" method="POST" action="{{ route('contacts.mass_edit') }}">
                    @csrf
                    <input type="hidden" name="contact_ids" id="contact_ids">
                    <h1 class="text-lg font-semibold text-center mb-3">Mass Edit Form</h1>

                    <div class="grid grid-cols-1 gap-2">
                        <div>
                            <label for="resources" class="block text-gray-700 padds">Resources:</label>
                            <input type="text" name="resources" id="resources"
                                class="w-full rounded-lg border padds py-1 focus:outline-none focus:ring-2 focus:ring-blue-600">
                        </div>
                        <div>
                            <label for="status_id" class="block text-gray-700 padds">Status:</label>
                            <select id="status_id" name="status_id"
                                class="w-full rounded-lg border padds py-1 focus:outline-none focus:ring-2 focus:ring-blue-600">
                                <option value="">-- Select Status --</option>
                                @foreach ($statuses as $status)
                                    @if (!empty($status) && isset($status->id))
                                        <option value="{{ $status->id }}">{{ $status->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="type_id" class="block text-gray-700 padds">Type:</label>
                            <select id="type_id" name="type_id"
                                class="w-full rounded-lg border padds py-1 focus:outline-none focus:ring-2 focus:ring-blue-600">
                                <option value="">-- Select Type --</option>
                                @foreach ($types as $type)
                                    @if (!empty($type) && isset($type->id))
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="industry" class="block text-gray-700 padds">Industry:</label>
                            <input type="text" name="industry" id="industry"
                                class="w-full rounded-lg border padds py-1 focus:outline-none focus:ring-2 focus:ring-blue-600">
                        </div>
                        <div>
                            <label for="company" class="block text-gray-700 padds">Company:</label>
                            <input type="text" name="company" id="company"
                                class="w-full rounded-lg border padds py-1 focus:outline-none focus:ring-2 focus:ring-blue-600">
                        </div>
                        <div>
                            <label for="product" class="block text-gray-700 padds">Product:</label>
                            <input type="text" name="product" id="product"
                                class="w-full rounded-lg border padds py-1 focus:outline-none focus:ring-2 focus:ring-blue-600">
                        </div>
                        <div>
                            <label for="bgoc_product" class="block text-gray-700 padds">BGOC Product:</label>
                            <input type="text" name="bgoc_product" id="bgoc_product"
                                class="w-full rounded-lg border padds py-1 focus:outline-none focus:ring-2 focus:ring-blue-600">
                        </div>
                        <div>
                            <label for="pic" class="block text-gray-700 padds">PIC:</label>
                            <input type="text" name="pic" id="pic"
                                class="w-full rounded-lg border padds py-1 focus:outline-none focus:ring-2 focus:ring-blue-600">
                        </div>
                        <div>
                            <label for="address" class="block text-gray-700 padds">Address:</label>
                            <input type="text" name="address" id="address"
                                class="w-full rounded-lg border padds py-1 focus:outline-none focus:ring-2 focus:ring-blue-600">
                        </div>
                        <div>
                            <label for="state_id" class="block text-gray-700 padds">State:</label>
                            <select id="state1" name="state_id"
                                class="w-full rounded-lg border padds py-1 focus:outline-none focus:ring-2 focus:ring-blue-600">
                                <option value="">Select State</option>
                                @foreach ($states as $state)
                                    <option value="{{ $state->id }}" {{ request('state_id') == $state->id ? 'selected' : '' }}>
                                        {{ $state->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="city_id" class="block text-gray-700 padds">City:</label>
                            <select id="city1" name="city_id"
                                class="w-full rounded-lg border padds py-1 focus:outline-none focus:ring-2 focus:ring-blue-600">
                                <option value="">Select City</option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city->id }}" {{ request('city_id') == $city->id ? 'selected' : '' }}>
                                        {{ $city->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success btn-link">Mass Edit</button>
                </form>
                </div>

        </div>
    </div>
    <div class="botts"><x-footers.auth></x-footers.auth></div>
    </main>
    <x-plugins></x-plugins>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script type="text/javascript" src="https://unpkg.com/default-passive-events"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                paging: false,  // Disable pagination
                info: false,      // Disable the "Showing x to y of z entries" message
                "columnDefs": [
                {
                    "targets": [0],  // Disable sorting for Sub Folder, UserName, and Resources columns
                    "orderable": false
                }
            ]
            });
        });
    </script>
    {{-- Select State & City Button --}}
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
    {{-- Hidden Collumn --}}
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
    {{-- Export Button Function --}}
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
    {{-- MassEdit Checkbox --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const selectAllCheckbox = document.getElementById('select-all-checkbox');
            const deleteForm = document.getElementById('delete-form');
            const actionButtons = document.getElementById('action-buttons');
            const massEditContactIdsInput = document.getElementById('contact_ids');
            const deleteContactIdsInput = document.getElementById('delete_contact_ids');

            function updateActionButtonVisibility() {
                console.log("Updating action button visibility...");
                const selectedContacts = Array.from(document.querySelectorAll('.contact-checkbox:checked')).map(cb => cb.value);
                console.log("Selected contacts:", selectedContacts);

                if (selectedContacts.length > 0) {
                    deleteForm.style.display = 'block';
                    actionButtons.style.display = 'block';
                    massEditContactIdsInput.value = selectedContacts.join(',');
                    deleteContactIdsInput.value = selectedContacts.join(',');
                } else {
                    deleteForm.style.display = 'none';
                    actionButtons.style.display = 'none';
                    massEditContactIdsInput.value = '';
                    deleteContactIdsInput.value = '';
                }

                // Update "Select All" checkbox
                const allCheckboxes = document.querySelectorAll('.contact-checkbox');
                selectAllCheckbox.checked = selectedContacts.length === allCheckboxes.length;
            }

            function toggleSelectAll(event) {
                console.log('"Select All" checkbox changed:', event.target.checked);
                document.querySelectorAll('.contact-checkbox').forEach(cb => cb.checked = event.target.checked);
                updateActionButtonVisibility();
            }

            document.addEventListener('change', function (event) {
                if (event.target.classList.contains('contact-checkbox')) updateActionButtonVisibility();
                if (event.target.id === 'select-all-checkbox') toggleSelectAll(event);
            });

            // Edit button functionality
            const editButton = document.getElementById('edit-button');
            if (editButton) {
                editButton.addEventListener('click', function () {
                    document.getElementById('mass-edit-form-container').style.display = 'block';
                    document.getElementById('modal-overlay').style.display = 'block';
                    actionButtons.style.display = 'none';
                });
            }

            // Modal close functionality
            const closeButton = document.getElementById('closeMassEditForm');
            if (closeButton) {
                closeButton.addEventListener('click', function () {
                    document.getElementById('mass-edit-form-container').style.display = 'none';
                    document.getElementById('modal-overlay').style.display = 'none';
                });
            }

            const modalOverlay = document.getElementById('modal-overlay');
            if (modalOverlay) {
                modalOverlay.addEventListener('click', function () {
                    document.getElementById('mass-edit-form-container').style.display = 'none';
                    this.style.display = 'none';
                });
            }
        });
    </script>

    {{-- Toggle Search Button --}}
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

</x-layout>
