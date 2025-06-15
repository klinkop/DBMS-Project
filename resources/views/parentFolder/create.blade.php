<x-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Folder') }}
        </h2>
    </x-slot>

    <x-navbars.sidebar activePage='parentFolder'></x-navbars.sidebar>

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <style>
            .rounde-custom {
                border-radius: 0.5rem;
            }

            .form-container {
                background-color: #fff;
                /* White background */
                border-radius: 0.5rem;
                /* Rounded corners */
                padding: 2rem;
                /* Padding inside the container */
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                /* Subtle shadow for depth */
            }

            .form-control {
                border: 1px solid #d1d5db;
                /* Light gray border */
                border-radius: 0.375rem;
                /* Rounded corners */
                padding: 0.5rem;
                /* Padding inside the input */
                width: 100%;
                /* Full width */
                transition: border-color 0.2s;
                /* Smooth transition for border color */
            }

            .form-control:focus {
                border-color: #3b82f6;
                /* Blue border on focus */
                outline: none;
                /* Remove default outline */
                box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5);
                /* Blue shadow on focus */
            }
        </style>
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Create Folder"></x-navbars.navs.auth>
        <!-- End Navbar -->

        <!-- Form Container -->
        <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
            <div class="form-container">
                <form action="{{ route('parentFolder.store') }}" method="post">
                    @csrf
                    <!-- Input Form -->
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-700">Folder Name</label>
                        <input type="text" class="form-control" id="name" name="name"
                            placeholder="Enter folder name">
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mt-4 space-x-2">
                        <x-primary-button>{{ __('Add Parent Folder') }}</x-primary-button>
                        <button type="button" onclick="history.back()"
                                        class="btn btn-danger">
                                        Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="botdash"><x-footers.auth></x-footers.auth></div>
    </main>
    <x-plugins></x-plugins>
</x-layout>
