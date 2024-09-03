<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        {{-- Add Search Form --}}
        <form action="{{ route('parentFolder.index') }}" method="get" class="form-inline my-4">
            <input type="search" name="squery" class="form-control mr-sm-2" placeholder="Search Parent Folder" aria-label="Search">
            <button class="btn btn-outline-indigo my-2 my-sm-0" type="submit">{{ __('Search') }}</button>
        </form>

        {{-- Add on Title and Create Parent Folder button here! --}}
        <h1 class="text-3xl font-bold leading-tight text-gray-900">{{ __('Parent Folders List') }}</h1>
        <a href="{{ route('parentFolder.create') }}"
            class="inline-flex items-center px-4 py-2 mt-4 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            {{ __('Create Parent Folder') }}
        </a>

        <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
            @foreach ($parentFolders as $parentFolder)
                <div class="p-6 flex space-x-2">
                    <svg xmlns="http://www.w3.org/200/svg" class="h-6 w-6 text-gray-600 -scale-x-100" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                    </svg>
                    <div class="flex-1">
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="text-gray-800">{{ $parentFolder->user->name }}</span>
                                <small
                                    class="ml-2 text-sm text-gray-600">{{ $parentFolder->created_at->format('j M Y, g:i a') }}</small>
                                @unless ($parentFolder->created_at->eq($parentFolder->updated_at))
                                    <small class="text-sm text-gray-600"> &middot; {{ __('edited on') }}
                                        {{ $parentFolder->updated_at->format('j M Y, g:i a') }}</small>
                                @endunless
                            </div>
                            @if ($parentFolder->user->is(auth()->user()))
                                {{-- dropdown for each instance of Parent Folder --}}
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
                                        <x-dropdown-link :href="route('subFolder.create', $parentFolder)">
                                            {{ __('Create Sub Folder') }}
                                        </x-dropdown-link>
                                        <x-dropdown-link :href="route('parentFolder.edit', $parentFolder)">
                                            {{ __('Edit') }}
                                        </x-dropdown-link>
                                        <x-dropdown-link :href="route('subFolder.index', ['parentFolder' => $parentFolder->id])">
                                            {{ __('View Subfolders') }}
                                        </x-dropdown-link>
                                        <form action="{{ route('parentFolder.destroy', $parentFolder) }}"
                                            method="post">
                                            @csrf
                                            @method('delete')
                                            <x-dropdown-link href="route('parentFolder.destroy', $parentFolder)"
                                                onclick="event.preventDefault(); this.closest('form').submit();">
                                                {{ __('Delete') }}
                                            </x-dropdown-link>
                                        </form>
                                    </x-slot>
                                </x-dropdown>
                            @endif
                        </div>
                        <p class="mt-4 text-lg text-gray-900">{{ $parentFolder->name }}</p>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</x-app-layout>
