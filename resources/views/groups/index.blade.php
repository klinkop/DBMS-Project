<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Group') }}
        </h2>
    </x-slot>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        {{-- Add Search form --}}
        <form action="{{ route('groups.index') }}" method="get" class="form-inline my-4">
            <input type="search" name="squery" class="form-control mr-sm-2" placeholder="Search Group"
                aria-label="Search">
            <button class="btn btn-outline-indigo my-2 my-sm-0" type="submit">{{ __('Search') }}</button>
        </form>

        @if (request()->input('squery'))
            <h3>Search Result for: {{ request()->input('squery') }}</h3>
        @endif
        <a href="{{ route('groups.create') }}"
            class="inline-flex items-center px-4 py-2 mt-4 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            {{ __('Create Group') }}
        </a>

        <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
            @foreach ($groups as $group)
                <div class="p-6 flex space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600 -scale-x-100" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <div class="flex-1">
                        <div class="flex justify-between items-center">
                            <div>
                                <span class="text-gray-800">{{ $group->user->name }}</span>
                                <small
                                    class="ml-2 text-sm text-gray-600">{{ $group->created_at->format('j M Y, g:i a') }}</small>
                                @unless ($group->created_at->eq($group->updated_at))
                                    <small class="text-sm text-gray-600"> &middot; {{ __('edited') }}</small>
                                @endunless
                            </div>
                            @if ($group->user->is(auth()->user()))
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
                                        <x-dropdown-link :href="route('groups.edit', $group)">
                                            {{ __('Edit') }}
                                        </x-dropdown-link>
                                        <form method="POST" action="{{ route('groups.destroy', $group) }}">
                                            @csrf
                                            @method('delete')
                                            <x-dropdown-link :href="route('groups.destroy', $group)"
                                                onclick="event.preventDefault(); this.closest('form').submit();">
                                                {{ __('Delete') }}
                                            </x-dropdown-link>
                                        </form>
                                    </x-slot>
                                </x-dropdown>
                            @endif
                        </div>
                        <p class="mt-4 text-lg text-gray-900">{{ $group->name }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
