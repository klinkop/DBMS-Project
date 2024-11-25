<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Campaigns') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">

        <!-- Add a button to create a new campaign -->
        <div class="mb-4">
            <a href="{{ route('campaigns.create') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                Create Campaign
            </a>
        </div>

        <!-- Display success message after deleting a campaign -->
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Campaigns Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border-collapse border border-gray-300">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b border-gray-300 text-left text-gray-600 font-bold">#</th>
                        <th class="py-2 px-4 border-b border-gray-300 text-left text-gray-600 font-bold">Name</th>
                        <th class="py-2 px-4 border-b border-gray-300 text-left text-gray-600 font-bold">Open Count
                        </th>
                        <th class="py-2 px-4 border-b border-gray-300 text-left text-gray-600 font-bold">Click Count
                        </th>
                        <th class="py-2 px-4 border-b border-gray-300 text-left text-gray-600 font-bold">Bounce Count
                        </th>
                        <th class="py-2 px-4 border-b border-gray-300 text-left text-gray-600 font-bold">Scheduled At
                        </th>
                        <th class="py-2 px-4 border-b border-gray-300 text-left text-gray-600 font-bold">Status</th>
                        <th class="py-2 px-4 border-b border-gray-300 text-left text-gray-600 font-bold">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($campaigns as $campaign)
                        <tr>
                            <td class="py-2 px-4 border-b border-gray-300">{{ $campaign->id }}</td>
                            <td class="py-2 px-4 border-b border-gray-300">{{ $campaign->name }}</td>
                            <td class="py-2 px-4 border-b border-gray-300">{{ $campaign->open_count }}</td>
                            <td class="py-2 px-4 border-b border-gray-300">{{ $campaign->click_count }}</td>
                            <td class="py-2 px-4 border-b border-gray-300">{{ $campaign->bounce_count }}</td>
                            <td class="py-2 px-4 border-b border-gray-300">
                                {{ $campaign->scheduled_at ? \Carbon\Carbon::parse($campaign->scheduled_at)->format('Y-m-d H:i') : 'Not Scheduled' }}
                            </td>
                            <td class="py-2 px-4 border-b border-gray-300">{{ $campaign->status }}</td>
                            <td class="py-2 px-4 border-b border-gray-300">
                                <!-- View button -->
                                <a href="{{ route('campaigns.show', $campaign->id) }}"
                                    class="inline-flex items-center px-2 py-1 bg-blue-500 text-white text-xs font-semibold rounded-md hover:bg-blue-600">
                                    Manage
                                </a>

                                <!-- Edit button -->
                                {{-- <a href="{{ route('campaigns.edit', $campaign->id) }}"
                                    class="inline-flex items-center px-2 py-1 bg-yellow-500 text-white text-xs font-semibold rounded-md hover:bg-yellow-600">
                                    Edit
                                </a> --}}
                                <!-- Duplicate button -->
                                <form action="{{ route('campaigns.duplicate', $campaign->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center px-2 py-1 bg-yellow-500 text-white text-xs font-semibold rounded-md hover:bg-blue-600">
                                        Duplicate
                                    </button>
                                </form>
                                <!-- Delete form -->
                                <form action="{{ route('campaigns.destroy', $campaign->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="inline-flex items-center px-2 py-1 bg-red-500 text-white text-xs font-semibold rounded-md hover:bg-red-600"
                                        onclick="return confirm('Are you sure you want to delete this campaign?')">
                                        Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination (if campaigns are paginated) -->
        <div class="mt-4">
            {{ $campaigns->links('pagination::tailwind') }}
        </div>

    </div>

</x-app-layout>
