<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Campaign') }}
        </h2>
    </x-slot>

    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <form action="{{ route('campaigns.index') }}" method="get" class="form-inline my-4">
            <input type="search" name="squery" class="form-control mr-sm-2" placeholder="Search Campaign"
                aria-label="Search">
            <button type="submit" class="btn btn-outline-indigo my-2 my-sm-0">{{ __('Search') }}</button>
        </form>

        @if (request()->input('squery'))
            <h3>Search Result for: {{ request()->input('squery') }}</h3>
        @endif

        <a href="{{ route('campaigns.create') }}"
            class="inline-flex items-center px-4 py-2 mt-4 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            {{ __('Create campaign') }}
        </a>

        <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
            @foreach ($campaigns as $campaign)
                <div class="p-6 flex space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 8l7.29 5.33c.58.42 1.35.42 1.93 0L21 8M5 19h14c1.1 0 2-.9 2-2V7c0-1.1-.9-2-2-2H5c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2z" />
                    </svg>

                    <div class="flex-1">
                        <div class="flex justify-between items-center mb-4">
                            <div>
                                <a class="capitalize"
                                    href="{{ route('campaigns.show', $campaign) }}">{{ $campaign->name }}</a>
                                {{-- <span class="mt-4 text-lg text-gray-900">{{ $campaign->name }}</span> --}}
                                <small
                                    class="ml-2 text-sm text-gray-600">{{ $campaign->created_at->format('j M Y, g:i a') }}</small>
                                @unless ($campaign->created_at->eq($campaign->updated_at))
                                    <small class="text-sm text-gray-600"> &middot; {{ __('edited') }}</small>
                                @endunless
                            </div>
                            @if ($campaign->user->is(auth()->user()))
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
                                        <x-dropdown-link :href="route('campaigns.addReceipient', $campaign)">
                                            {{ __('Manage Receipient') }}
                                        </x-dropdown-link>
                                        <x-dropdown-link :href="route('campaigns.edit', $campaign)">
                                            {{ __('Edit') }}
                                        </x-dropdown-link>
                                        <form method="POST" action="{{ route('campaigns.destroy', $campaign) }}">
                                            @csrf
                                            @method('delete')
                                            <x-dropdown-link :href="route('campaigns.destroy', $campaign)"
                                                onclick="event.preventDefault(); this.closest('form').submit();">
                                                {{ __('Delete') }}
                                            </x-dropdown-link>
                                        </form>
                                    </x-slot>
                                </x-dropdown>
                            @endif
                        </div>
                        <p class="mt-4 text-lg text-gray-900">Status: {{ $campaign->status }}</p>
                        <p class="mt-4 text-lg text-gray-900">
                            No. of Receipients: {{ $campaign->receipients->count() }} SubFolders
                        </p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
