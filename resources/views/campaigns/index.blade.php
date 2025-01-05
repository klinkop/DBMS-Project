<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Campaigns') }}
        </h2>
    </x-slot>

    <x-navbars.sidebar activePage='campaign'></x-navbars.sidebar>

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">

    <style>
        .round{
            border-radius: 2rem
        }

        table {
            border: 2px solid #000; /* Solid black border around the table */
            border-radius: 10px; /* Adjust the value to control the curvature */
            overflow: hidden;    /* Ensures that the content doesn't overflow the rounded corners */
        }

        table th, table td {
            height: 50px;  /* Set fixed height for each cell */
        }

        .reoutline {
           border: transparent;
           background: transparent;
        }

    </style>

    <x-navbars.navs.auth titlePage="Campaign"></x-navbars.navs.auth>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

        <!-- Display success message -->
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        <!-- Campaigns Table or Empty State -->
        @if ($campaigns->isEmpty())
        <div class="text-center text-gray-500">
            <p>No campaigns have been created yet.</p>
            <a href="{{ route('campaigns.create') }}"
                class="mt-4 inline-block px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                Create Your First Campaign
            </a>
        </div>
        @else
        <!-- If there are campaigns, display the Create button above the table -->
        @if (!$campaigns->isEmpty())
        <div class="">
            <a href="{{ route('campaigns.create') }}"
                class="btn bg-gradient-dark">
                Create Campaign
            </a>
        </div>
        @endif
            <div class="overflow-x-auto round px-5">
                <table id="myTable" class="display min-w-full border-collapse border border-gray-300 round table">
                    <thead>
                        <tr>
                            <!--<th class="py-2 px-4 border-b border-gray-300 text-left text-gray-600 font-bold">#</th>-->
                            <th class="py-2 px-4 border-b border-gray-300 text-left text-gray-600 font-bold">Name</th>
                            <th class="py-2 px-4 border-b border-gray-300 text-center text-gray-600 font-bold">Description</th>
                            <th class="py-2 px-4 border-b border-gray-300 text-center text-gray-600 font-bold">Subject</th>
                            <th class="py-2 px-4 border-b border-gray-300 text-center text-gray-600 font-bold">Open Rate</th>
                            <th class="py-2 px-4 border-b border-gray-300 text-center text-gray-600 font-bold">Click Rate</th>
                            <th class="py-2 px-4 border-b border-gray-300 text-center text-gray-600 font-bold">TotalEmails Sent</th>
                            <th class="py-2 px-4 border-b border-gray-300 text-center text-gray-600 font-bold">Scheduled At</th>
                            <th class="py-2 px-4 border-b border-gray-300 text-center text-gray-600 font-bold">Status</th>
                            <th class="py-2 px-4 border-b border-gray-300 text-center text-gray-600 font-bold">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($campaigns as $campaign)
                            <tr>
                                <!--<td class="py-2 px-4 border-b border-gray-300">{{ $campaign->id }}</td>-->
                                <td class="py-2 px-4 border-b border-gray-300">{{ $campaign->name }}</td>
                                <td class="py-2 px-4 border-b border-gray-300 text-center">{{ $campaign->description }}</td>
                                <td class="py-2 px-4 border-b border-gray-300 text-center">{{ $campaign->email_subject }}</td>
                                <td class="py-2 px-4 border-b border-gray-300 text-center">{{ number_format($campaign->open_rate ?? 0, 2) }}%</td>
                                <td class="py-2 px-4 border-b border-gray-300 text-center">{{ number_format($campaign->click_rate ?? 0, 2) }}%</td>
                                <td class="py-2 px-4 border-b border-gray-300 text-center">{{ $campaign->total_emails_sent ?? 0 }}</td>
                                <td class="py-2 px-4 border-b border-gray-300 text-center">{{ $campaign->scheduled_at ? \Carbon\Carbon::parse($campaign->scheduled_at)->format('Y-m-d H:i') : 'Not Scheduled' }}</td>
                                <td class="py-2 px-4 border-b border-gray-300 text-center">{{ $campaign->status }}</td>
                                <td class="py-2 px-4 border-b border-gray-300 text-center">
                                    <!-- Dropdown Button -->
                                    <div class="">
                                        <button type="button" class="reoutline" data-dropdown="dropdown-{{ $campaign->id }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-30 w-30" viewBox="0 0 20 20" fill="currentColor">
                                                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                            </svg>
                                        </button>

                                        <!-- Dropdown Menu -->
                                        <div class="dropdown-menu absolute right-0 w-48 py-2 mt-1 bg-white border border-gray-300 rounded-md shadow-lg" id="dropdown-{{ $campaign->id }}" style="display: none;">
                                            <a href="{{ route('campaigns.show', $campaign->id) }}" class="dropdown-item">Manage</a>
                                            <form action="{{ route('campaigns.duplicate', $campaign->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" class="dropdown-item">Duplicate</button>
                                            </form>
                                            <form action="{{ route('campaigns.destroy', $campaign->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger" onclick="return confirm('Are you sure you want to delete this campaign?')">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="px-6">
                {{ $campaigns->links('') }}
            </div>
        @endif

    </div>
    </main>
    <x-plugins></x-plugins>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
                paging: false,  // Disable pagination
                info: false,      // Disable the "Showing x to y of z entries" message
                order: [], // Disable default sorting
                columnDefs: [
                    { orderable: false, targets: [-1] } // Disable sorting for the Actions column (or other specific columns)
                ],
            });
        });
    </script>
    <script>
        document.querySelectorAll('[data-dropdown]').forEach(function(button) {
            button.addEventListener('click', function() {
                const dropdownId = button.getAttribute('data-dropdown');
                const dropdownMenu = document.getElementById(dropdownId);
                dropdownMenu.style.display = dropdownMenu.style.display === 'none' ? 'block' : 'none';

                // Close all other dropdowns except the clicked one
                document.querySelectorAll('.dropdown-menu').forEach(function(menu) {
                    if (menu.id !== dropdownId) {
                        menu.style.display = 'none';
                    }
                });
            });
        });
    </script>
</x-layout>
