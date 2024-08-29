<x-app-layout>

    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        {{-- Add Search Form --}}
        <form action="{{ route('subFolder.index') }}" method="get" class="form-inline my-4">
            <input type="search" name="squery" class="form-control mr-sm-2" placeholder="Search Sub Folder" aria-label="Search">
            <button class="btn btn-outline-indigo my-2 my-sm-0" type="submit">{{ __('Search') }}</button>
        </form>
        {{-- Add paths --}}
        <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
            @foreach ($subFolders as $subFolder)
                <div class="p-6 flex space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 -scale-x-100" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                    </svg>
                    <div class="flex-1">
                        <div class="flex justify-between items-center">
                            <div>
                                {{-- Displays the Parent Folder of the Sub Folder --}}
                                <span class="text-gray-800">{{ $subFolder->parentFolder->name }}</span>
                                <small class="ml-2 text-sm text-gray-600">{{ __('Created by') }}
                                    {{ $subFolder->user->name }}
                                    {{ $subFolder->created_at->format('j M Y, g:i a') }}</small>
                                @unless ($subFolder->created_at->eq($subFolder->updated_at))
                                    <small class="text-sm text-gray-600"> &middot; {{ __('edited') }}</small>
                                @endunless
                            </div>
                            @if ($subFolder->user->is(auth()->user()))
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
                                        <x-dropdown-link :href="route('contactList.create', $subFolder)">
                                            {{ __('Add Contact') }}
                                        </x-dropdown-link>
                                        <x-dropdown-link :href="route('subFolder.edit', $subFolder)">
                                            {{ __('Edit') }}
                                        </x-dropdown-link>
                                        <x-dropdown-link :href="route('contactList.index', ['subFolder' => $subFolder->id])">
                                            {{ __('View Contacts') }}
                                        </x-dropdown-link>
                                        <form method="POST" action="{{ route('subFolder.destroy', $subFolder) }}">
                                            @csrf
                                            @method('delete')
                                            <x-dropdown-link :href="route('subFolder.destroy', $subFolder)"
                                                onclick="event.preventDefault(); this.closest('form').submit();">
                                                {{ __('Delete') }}
                                            </x-dropdown-link>
                                        </form>
                                    </x-slot>
                                </x-dropdown>
                            @endif
                        </div>
                        <p class="mt-4 text-lg text-gray-900">{{ $subFolder->name }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
