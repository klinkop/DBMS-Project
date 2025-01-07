<x-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Folder') }}
        </h2>
    </x-slot>

    <x-navbars.sidebar activePage='parentFolder'></x-navbars.sidebar>

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <style>
            /* Custom rounded class */
            .rounded-custom {
                border-radius: 0.5rem;
            }
        </style>
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Folders"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4 relative overflow-visible">

            {{-- add on title and create folder button here --}}

            <a href="{{ route('parentFolder.create') }}" class="btn bg-gradient-dark mb-0">
                {{ __('Create Parent Folder') }}
            </a>

            {{-- Add search form --}}
            <form action="{{ route('parentFolder.index') }}" method="get"
                class="ms-md-auto pe-md-3 d-flex align-items-center">
                <div class="input-group input-group-outline" style="width: 300px;">
                    <label class="form-label">Search Folder</label>
                    <input type="search" name="squery" class="form-control" aria-label="Search">
                </div>
                <button type="submit" class="btn btn-outline-indigo ms-2">{{ __('Search') }}</button>
            </form>

            <div class="row gap-4">
            @foreach ($parentFolders as $parentFolder)
                <div
                    class="card col-lg-5 col-md-4 mt-4 mb-4 p-4">
                    {{-- text and dropdown --}}
                    <div class="flex-1 rounded-lg">
                        <div class="flex justify-between items-start rounded-lg">
                            <div class="flex items-center rounded-lg">
                                {{-- icon --}}
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-gray-600 -scale-x-100 mr-2"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                                </svg>
                                <span class="text-gray-800 font-semibold">{{ $parentFolder->user->name }}</span>
                                <small
                                    class="ml-2 text-sm text-gray-600">{{ $parentFolder->created_at->format('j M Y, g:i a') }}</small>
                                @unless ($parentFolder->created_at->eq($parentFolder->updated_at))
                                    <small class="text-sm text-gray-600"> &middot; {{ __('edited_on') }}
                                        {{ $parentFolder->updated_at->format('j M Y, g:i a') }}</small>
                                @endunless
                            </div>

                            {{-- Folder Name and Action Button --}}
                            <div class="container folder-container">
                                <div class="row justify-content-between">
                                    <div class="col-4">
                                        <p class="mt-4 text-lg text-gray-900">{{ $parentFolder->name }}</p>
                                    </div>
                                    <div class="col-4">
                                        {{-- Action button container --}}
                                        @if ($parentFolder->user->is(auth()->user()))
                                            <div class="row">
                                                <div class="mb-3 col-md-6">
                                                    <button class="btn btn-info dropdown-toggle" type="button"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        Action
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a class="dropdown-item text-gray-600 hover:bg-gray-100"
                                                                href="{{ route('subFolder.create', $parentFolder) }}">
                                                                Create Sub Folder
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item text-gray-600 hover:bg-gray-100"
                                                                href="{{ route('parentFolder.edit', $parentFolder) }}">
                                                                {{ __('Edit') }}
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item text-gray-600 hover:bg-gray-100"
                                                                href="{{ route('subFolder.index', ['parentFolder' => $parentFolder->id]) }}">
                                                                {{ __('View Subfolders') }}
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <form
                                                                action="{{ route('parentFolder.destroy', $parentFolder) }}"
                                                                method="post">
                                                                @csrf
                                                                @method('delete')
                                                                <a href="#"
                                                                    class="dropdown-item text-danger hover:bg-red-100"
                                                                    onclick="event.preventDefault();
                                                                if(confirm('Are you sure you want to delete this folder? This action cannot be undone.')) {
                                                                    this.closest('form').submit();
                                                                }">
                                                                    {{ __('Delete') }}
                                                                </a>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach
            </div>
            <div class="mt-4">
                {{ $parentFolders->links() }}
            </div>
        </div>
        <div class="botdash"><x-footers.auth></x-footers.auth></div>
    </main>
    <x-plugins></x-plugins>
</x-layout>
