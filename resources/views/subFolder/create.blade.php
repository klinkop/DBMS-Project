
<x-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Sub Folder') }}
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
        <x-navbars.navs.auth titlePage="Create Sub Folder"></x-navbars.navs.auth>
        <!-- End Navbar -->

        <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
            <div class="form-container">
                <form method="POST" action="{{ route('subFolder.store') }}">
                    @csrf
                    <div class="mb-4 row">
                        <label for="name" class="col-sm-2 col-form-label">Folder Name</label>
                        <div>
                            <input type="text" readonly class="form-control" id="name"
                                value="{{ old('name', $parentFolder->name) }}">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="name" class="col-sm-2 col-form-label">Sub Folder Name</label>
                        <input type="text" class="form-control" id="name" name="name"
                            placeholder="Enter Sub Folder name">
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    {{-- Hidden input: parent_folder_id, passed from the parent folder index --}}
                    <input type="hidden" name="parent_folder_id" value="{{ $parentFolder->id }}" />

                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    <x-primary-button class="mt-4">{{ __('Add Sub Folder') }}</x-primary-button>
                </form>
            </div>
        </div>
        <div class="botdash"><x-footers.auth></x-footers.auth></div>
    </main>
    <x-plugins></x-plugins>
</x-layout>
