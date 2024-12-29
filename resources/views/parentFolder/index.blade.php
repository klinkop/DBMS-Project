<x-layout bodyClass="g-sidenav-show  bg-gray-200">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Parent Folder') }}
        </h2>
    </x-slot>

    <x-navbars.sidebar activePage='parentFolder'></x-navbars.sidebar>

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <style>
            /* Custom rounded class */
            .rounded-custom {
                border-radius: 0.5rem; /* Equivalent to Tailwind's rounded-lg */
            }
        </style>
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Folders"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4 relative overflow-visible">

            {{-- Add on Title and Create Parent Folder button here! --}}
            {{-- <h1 class="text-3xl font-bold leading-tight text-gray-900">{{ __('Parent Folders List') }}</h1> --}}
            <a href="{{ route('parentFolder.create') }}"
                class="btn bg-gradient-dark mb-0">
                {{ __('Create Parent Folder') }}
            </a>

            {{-- Add Search Form --}}
            <form action="{{ route('parentFolder.index') }}" method="get" class="ms-md-auto pe-md-3 d-flex align-items-center">
                <div class="input-group input-group-outline" style="width: 300px;">
                    <label class="form-label">Search Folder</label>
                    <input type="search" name="squery" class="form-control" aria-label="Search">
                </div>
                <button class="btn btn-outline-indigo ms-2" type="submit">{{ __('Search') }}</button>
            </form>


                @foreach ($parentFolders as $parentFolder)
                <div class="p-4 flex items-start space-x-4 mt-3 bg-white shadow-sm rounded-custom divide-y overflow-hidden w-full">
                    <!-- Text and Dropdown -->
                    <div class="flex-1 rounded-lg">
                        <div class="flex justify-between items-start rounded-lg">
                            <div class="flex items-center rounded-lg">
                                <!-- Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-gray-600 -scale-x-100 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                                </svg>
                                <span class="text-gray-800 font-semibold">{{ $parentFolder->user->name }}</span>
                                <small class="ml-2 text-sm text-gray-600">{{ $parentFolder->created_at->format('j M Y, g:i a') }}</small>
                                @unless ($parentFolder->created_at->eq($parentFolder->updated_at))
                                    <small class="text-sm text-gray-600"> &middot; {{ __('edited on') }}
                                        {{ $parentFolder->updated_at->format('j M Y, g:i a') }}</small>
                                @endunless

                                @if ($parentFolder->user->is(auth()->user()))
                                <!-- Dropdown for Parent Folder Options -->

                                    <button class="btn btn-link text-gray-600 dropdown-toggle p-0 absolute top-0 right-0" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                            <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                        </svg>
                                    </button>
                                    <ul class="dropdown-menu bg-white shadow-md rounded-lg border border-gray-300 absolute left-0 top-full mt-1 overflow-visible" aria-labelledby="dropdownMenuButton">
                                        <li>
                                            <a class="dropdown-item text-gray-600 hover:bg-gray-100" href="{{ route('subFolder.create', $parentFolder) }}">
                                                {{ __('Create Sub Folder') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item text-gray-600 hover:bg-gray-100" href="{{ route('parentFolder.edit', $parentFolder) }}">
                                                {{ __('Edit') }}
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item text-gray-600 hover:bg-gray-100" href="{{ route('subFolder.index', ['parentFolder' => $parentFolder->id]) }}">
                                                {{ __('View Subfolders') }}
                                            </a>
                                        </li>
                                        <li>
                                            <form action="{{ route('parentFolder.destroy', $parentFolder) }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <button type="submit" class="dropdown-item text-danger hover:bg-red-100">
                                                    {{ __('Delete') }}
                                                </button>
                                            </form>
                                        </li>
                                    </ul>

                            @endif
                            </div>


                        </div>

                        <!-- Folder Name -->
                        <p class="mt-2 text-xl font-medium text-gray-900">{{ $parentFolder->name }}</p>
                    </div>
                </div>

                @endforeach


        </div>
    </main>
    <x-plugins></x-plugins>

    @push('js')
    <script src="{{ asset('assets') }}/js/plugins/chartjs.min.js"></script>
    <script>
        var ctx = document.getElementById("chart-bars").getContext("2d");

        new Chart(ctx, {
            type: "bar",
            data: {
                labels: ["M", "T", "W", "T", "F", "S", "S"],
                datasets: [{
                    label: "Sales",
                    tension: 0.4,
                    borderWidth: 0,
                    borderRadius: 4,
                    borderSkipped: false,
                    backgroundColor: "rgba(255, 255, 255, .8)",
                    data: [50, 20, 10, 22, 50, 10, 40],
                    maxBarThickness: 6
                }, ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                scales: {
                    y: {
                        grid: {
                            drawBorder: false,
                            display: true,
                            drawOnChartArea: true,
                            drawTicks: false,
                            borderDash: [5, 5],
                            color: 'rgba(255, 255, 255, .2)'
                        },
                        ticks: {
                            suggestedMin: 0,
                            suggestedMax: 500,
                            beginAtZero: true,
                            padding: 10,
                            font: {
                                size: 14,
                                weight: 300,
                                family: "Roboto",
                                style: 'normal',
                                lineHeight: 2
                            },
                            color: "#fff"
                        },
                    },
                    x: {
                        grid: {
                            drawBorder: false,
                            display: true,
                            drawOnChartArea: true,
                            drawTicks: false,
                            borderDash: [5, 5],
                            color: 'rgba(255, 255, 255, .2)'
                        },
                        ticks: {
                            display: true,
                            color: '#f8f9fa',
                            padding: 10,
                            font: {
                                size: 14,
                                weight: 300,
                                family: "Roboto",
                                style: 'normal',
                                lineHeight: 2
                            },
                        }
                    },
                },
            },
        });


        var ctx2 = document.getElementById("chart-line").getContext("2d");

        new Chart(ctx2, {
            type: "line",
            data: {
                labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [{
                    label: "Mobile apps",
                    tension: 0,
                    borderWidth: 0,
                    pointRadius: 5,
                    pointBackgroundColor: "rgba(255, 255, 255, .8)",
                    pointBorderColor: "transparent",
                    borderColor: "rgba(255, 255, 255, .8)",
                    borderColor: "rgba(255, 255, 255, .8)",
                    borderWidth: 4,
                    backgroundColor: "transparent",
                    fill: true,
                    data: [50, 40, 300, 320, 500, 350, 200, 230, 500],
                    maxBarThickness: 6

                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                scales: {
                    y: {
                        grid: {
                            drawBorder: false,
                            display: true,
                            drawOnChartArea: true,
                            drawTicks: false,
                            borderDash: [5, 5],
                            color: 'rgba(255, 255, 255, .2)'
                        },
                        ticks: {
                            display: true,
                            color: '#f8f9fa',
                            padding: 10,
                            font: {
                                size: 14,
                                weight: 300,
                                family: "Roboto",
                                style: 'normal',
                                lineHeight: 2
                            },
                        }
                    },
                    x: {
                        grid: {
                            drawBorder: false,
                            display: false,
                            drawOnChartArea: false,
                            drawTicks: false,
                            borderDash: [5, 5]
                        },
                        ticks: {
                            display: true,
                            color: '#f8f9fa',
                            padding: 10,
                            font: {
                                size: 14,
                                weight: 300,
                                family: "Roboto",
                                style: 'normal',
                                lineHeight: 2
                            },
                        }
                    },
                },
            },
        });

        var ctx3 = document.getElementById("chart-line-tasks").getContext("2d");

        new Chart(ctx3, {
            type: "line",
            data: {
                labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [{
                    label: "Mobile apps",
                    tension: 0,
                    borderWidth: 0,
                    pointRadius: 5,
                    pointBackgroundColor: "rgba(255, 255, 255, .8)",
                    pointBorderColor: "transparent",
                    borderColor: "rgba(255, 255, 255, .8)",
                    borderWidth: 4,
                    backgroundColor: "transparent",
                    fill: true,
                    data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
                    maxBarThickness: 6

                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                scales: {
                    y: {
                        grid: {
                            drawBorder: false,
                            display: true,
                            drawOnChartArea: true,
                            drawTicks: false,
                            borderDash: [5, 5],
                            color: 'rgba(255, 255, 255, .2)'
                        },
                        ticks: {
                            display: true,
                            padding: 10,
                            color: '#f8f9fa',
                            font: {
                                size: 14,
                                weight: 300,
                                family: "Roboto",
                                style: 'normal',
                                lineHeight: 2
                            },
                        }
                    },
                    x: {
                        grid: {
                            drawBorder: false,
                            display: false,
                            drawOnChartArea: false,
                            drawTicks: false,
                            borderDash: [5, 5]
                        },
                        ticks: {
                            display: true,
                            color: '#f8f9fa',
                            padding: 10,
                            font: {
                                size: 14,
                                weight: 300,
                                family: "Roboto",
                                style: 'normal',
                                lineHeight: 2
                            },
                        }
                    },
                },
            },
        });

    </script>
    @endpush

</x-layout>
