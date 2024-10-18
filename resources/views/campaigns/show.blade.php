<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Campaign Details') }}
        </h2>
    </x-slot>

    <div class="max-w-4xl mx-auto p-6 sm:p-8 bg-gray-50 rounded-lg shadow-lg mt-10">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Campaign Name: <span
                    class="text-indigo-600">{{ $campaign->name }}</span></h2>
            <p class="text-lg text-gray-700">Status: <span
                    class="font-semibold text-yellow-600">{{ $campaign->status }}</span></p>
        </div>

        <div class="mt-8">
            <h3 class="text-xl font-semibold text-gray-900 mb-4">Recipients</h3>

            @if ($contactLists->isEmpty())
                <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg text-yellow-800">
                    No recipients found for this campaign.
                </div>
            @else
                <div class="mt-4 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="w-12 text-center">
                                    No.
                                </th>
                                <th scope="col" class="px-6 py-3 text-left text-gray-900 tracking-wider">
                                    Recipients
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @php
                                $count = 0;
                            @endphp
                            @foreach ($contactLists as $index => $contactList)
                                <tr class="hover:bg-gray-50 transition duration-150 ease-in-out">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ ++$count }} <!-- Counter starts from 1 -->
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $contactList->email }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
