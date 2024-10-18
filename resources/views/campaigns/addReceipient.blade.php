<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <h2 class="text-lg font-bold mb-4">Manage Receipients for {{ $campaign->name }}</h2>

        <form action="{{ route('campaigns.storeReceipient', $campaign->id) }}" method="post">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Campaign: </label>
                <p
                    class="block w-full bg-white border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm p-2">
                    {{ $campaign->name }}
                </p>
            </div>
            <div class="mb-4">
                <label for="sub_folder_id" class="block text-sm font-medium text-gray-700">Sub Folder:</label>
                <select name="sub_folder_id" id="sub_folder_id"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                    <option value="">-- Add Receipient --</option>
                    @foreach ($subFolders as $subFolder)
                        @if (!empty($subFolder) && isset($subFolder->id))
                            <option value="{{ $subFolder->id }}">{{ $subFolder->name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>

            <x-primary-button class="mt-4">{{ __('Add Sub Folder') }}</x-primary-button>
        </form>

        @if ($receipients->count() > 0)
            <div class="mt-4 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th>No.</th>
                            <th scope="col" class="px-6 py-3 text-left text-gray-900 tracking-wider">
                                Recipients
                            </th>
                            <th scope="col" class="px-2 py-3 text-center text-gray-900 tracking-wider">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @php
                            $count = 0;
                        @endphp
                        @foreach ($receipients as $receipient)
                            <tr>
                                <td class="text-center">{{ ++$count }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $receipient->subFolder->name }}
                                    </div>
                                </td>
                                <td class="px-2 py-4 whitespace-nowrap text-center">
                                    <div class="flex justify-center space-x-2">
                                        <!-- Show icon for contact list -->
                                        <a href="{{ route('contactList.index', ['subFolder' => $receipient->subFolder->id]) }}"
                                            class="text-blue-600 hover:text-blue-800" title="Show Contact List">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-.738 2.118-2.268 3.976-4.283 5.197C15.632 18.713 13.844 19 12 19c-1.844 0-3.632-.287-5.258-1.197C4.726 15.976 3.196 14.118 2.458 12z" />
                                            </svg>
                                        </a>

                                        <!-- Delete icon -->
                                        <form
                                            action="{{ route('campaigns.deleteReceipient', ['campaign' => $receipient->campaign_id, 'receipient' => $receipient->id]) }}"
                                            method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this recipient?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800"
                                                title="Delete Recipient">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M9 3h6l1 1h5v2H4V4h5l1-1zM5 7h14v12a2 2 0 01-2 2H7a2 2 0 01-2-2V7z" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p>No Receipient Listed</p>
        @endif

        @if (session('alert'))
            <script>
                alert('{{ session('alert') }}');
            </script>
        @endif
    </div>
</x-app-layout>
