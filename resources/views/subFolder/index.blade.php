<x-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Sub Folder') }}
        </h2>
    </x-slot>

    <x-navbars.sidebar activePage='subFolder'></x-navbars.sidebar>

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <style>
            /* Custom rounded class */
            .rounded-custom {
                border-radius: 0.5rem;
            }
        </style>
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Sub Folders"></x-navbars.navs.auth>
        <!-- End Navbar -->

        <div class="container-fluid py-4 relative overflow-visible">

                <form action="{{ route('subFolder.index') }}" method="get"
                    class="ms-md-auto pe-md-3 d-flex align-items-center">
                    <div class="input-group input-group-outline" style="width: 300px;">
                        <label class="form-label">Search Sub Folder</label>
                        <input type="search" name="squery" class="form-control" aria-label="Search">
                    </div>
                    <button type="submit" class="btn btn-outline-indigo ms-2">{{ __('Search') }}</button>
                </form>

            <div class="row gap-4">
                @foreach ($subFolders as $subFolder)
                    <div
                        class="card col-lg-5 col-md-4 mt-4 mb-4 p-4">
                        <div class="flex-1 rounded-lg">
                            <div class="flex justify-between items-start rounded-lg">
                                <div class="flex items-center rounded-lg">
                                    {{-- Displays the Parent Folder of the Sub Folder --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3 text-gray-600 -scale-x-100 mr-2"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                                    </svg>
                                    <span class="text-gray-800 font-semibold">{{ $subFolder->parentFolder->name }}</span>
                                    <small class="ml-2 text-sm text-gray-600">{{ __('Created by') }}
                                        {{ $subFolder->user->name }}
                                        {{ $subFolder->created_at->format('j M Y, g:i a') }}</small>
                                    @unless ($subFolder->created_at->eq($subFolder->updated_at))
                                        <small class="text-sm text-gray-600"> &middot; {{ __('edited') }}</small>
                                    @endunless
                                </div>
                                {{-- SubFolder name --}}
                                <div class="container subfolder-container">
                                    <div class="row justify-content-between">
                                        <div class="col-4">
                                            <p class="mt-4 text-lg text-gray-900">{{ $subFolder->name }}</p>
                                        </div>
                                        <div class="col-4">
                                            {{-- Action button --}}
                                            @if ($subFolder->user->is(auth()->user()))
                                                <div class="ml-auto pt-4">
                                                    <div class="btn-group">
                                                        <button class="btn btn-info dropdown-toggle" type="button"
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                            Action
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <a href="{{ route('contactList.create', $subFolder) }}"
                                                                    class="dropdown-item text-gray-600 hover:bg-gray-100">
                                                                    {{ __('Add Contact') }}
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('subFolder.edit', $subFolder) }}"
                                                                    class="dropdown-item text-gray-600 hover:bg-gray-100">
                                                                    {{ __('Edit') }}
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a href="{{ route('contactList.index', ['subFolder' => $subFolder->id]) }}"
                                                                    class="dropdown-item text-gray-600 hover:bg-gray-100">
                                                                    {{ __('View Contacts') }}
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <form method="POST"
                                                                    action="{{ route('subFolder.destroy', $subFolder) }}"
                                                                    style="display: inline;">
                                                                    @csrf
                                                                    @method('delete')
                                                                    <a href="#"
                                                                        class="dropdown-item text-danger hover:bg-red-100"
                                                                        onclick="event.preventDefault();
                                                                    if(confirm('Are you sure you want to delete this subfolder? This action cannot be undone.')) {
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
                <div class="mt-4">
                    {{ $subFolders->links() }}
                </div>
            </div>
        </div>
        <div class="botdash"><x-footers.auth></x-footers.auth></div>
    </main>
    <x-plugins></x-plugins>
</x-layout>
