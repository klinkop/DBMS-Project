<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Campaigns') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">

        <!-- If there are campaigns, display the Create button above the table -->
        @if (!$campaigns->isEmpty())
            <div class="mb-4">
                <a href="{{ route('campaigns.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-600 active:bg-blue-700 focus:outline-none focus:border-blue-700 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                    Create Campaign
                </a>
            </div>
        @endif

        <!-- Display success message -->
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Campaigns Table or Empty State -->
        @if ($campaigns->isEmpty())
            <div class="text-center text-gray-500">
                <p>No campaigns have been created yet.</p>
                <a href="{{ route('campaigns.create') }}"
                    class="mt-4 inline-block px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600">
                    Create Your First Campaign
                </a>
            </div>
        @else
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
                            <th class="py-2 px-4 border-b border-gray-300 text-left text-gray-600 font-bold">Open Rate
                            </th>
                            <th class="py-2 px-4 border-b border-gray-300 text-left text-gray-600 font-bold">Click Rate
                            </th>
                            <th class="py-2 px-4 border-b border-gray-300 text-left text-gray-600 font-bold">Total
                                Emails Sent</th>
                            <th class="py-2 px-4 border-b border-gray-300 text-left text-gray-600 font-bold">Scheduled
                                At</th>
                            <th class="py-2 px-4 border-b border-gray-300 text-left text-gray-600 font-bold">Status</th>
                            <th class="py-2 px-4 border-b border-gray-300 text-left text-gray-600 font-bold">Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($campaigns as $campaign)
                            <tr>
                                <td class="py-2 px-4 border-b border-gray-300">{{ $campaign->id }}</td>
                                <td class="py-2 px-4 border-b border-gray-300">{{ $campaign->name }}</td>
                                <td class="py-2 px-4 border-b border-gray-300">{{ $campaign->total_open_count ?? 0 }}
                                </td>
                                <td class="py-2 px-4 border-b border-gray-300">{{ $campaign->total_click_count ?? 0 }}
                                </td>
                                <td class="py-2 px-4 border-b border-gray-300">
                                    {{ number_format($campaign->open_rate ?? 0, 2) }}%
                                </td>
                                <td class="py-2 px-4 border-b border-gray-300">
                                    {{ number_format($campaign->click_rate ?? 0, 2) }}%
                                </td>
                                <td class="py-2 px-4 border-b border-gray-300">{{ $campaign->total_emails_sent ?? 0 }}
                                </td>
                                <td class="py-2 px-4 border-b border-gray-300">
                                    {{ $campaign->scheduled_at ? \Carbon\Carbon::parse($campaign->scheduled_at)->format('Y-m-d H:i') : 'Not Scheduled' }}
                                </td>
                                <td class="py-2 px-4 border-b border-gray-300">{{ $campaign->status }}</td>
                                <td class="py-2 px-4 border-b border-gray-300">
                                    <a href="{{ route('campaigns.show', $campaign->id) }}"
                                        class="inline-flex items-center px-2 py-1 bg-blue-500 text-white text-xs font-semibold rounded-md hover:bg-blue-600">
                                        Manage
                                    </a>
                                    <form action="{{ route('campaigns.duplicate', $campaign->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        <button type="submit"
                                            class="inline-flex items-center px-2 py-1 bg-yellow-500 text-white text-xs font-semibold rounded-md hover:bg-blue-600">
                                            Duplicate
                                        </button>
                                    </form>
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

            {{-- <div class="mt-4">
                {{ $campaigns->links() }}
            </div> --}}
        @endif


    </div>
</x-app-layout>
