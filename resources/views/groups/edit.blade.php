<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <h2 class="text-lg font-bold mb-4">Manage Group</h2>
        <form method="POST" action="{{ route('groups.update', $group) }}">
            @csrf
            @method('patch')
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Group Name</label>
                <input id="name" type="text" name="name"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                    value="{{ old('name', $group->name) }}">
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
            <div class="mt-4 space-x-2">
                <x-primary-button>{{ __('Save') }}</x-primary-button>
                <a href="{{ route('groups.index') }}">{{ __('Cancel') }}</a>
            </div>
        </form>

        {{-- Display contacts list --}}
        @if ($groupContacts->count() > 0)
            <div class="mt-4 overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th>No.</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Contact List
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @php
                            $count = 0;
                        @endphp
                        @foreach ($groupContacts as $groupContact)
                            <tr>
                                <td class="text-center">{{ ++$count }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $groupContact->contactList->email }}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p>No Contact Listed</p>
        @endif

        {{-- Add new contact form --}}
        <form action="{{ route('groups.addGroupContact', $group->id) }}" method="post">
            @csrf
            {{-- contact list dropdown --}}
            <div class="mb-4">

                <select name="contact_list_id" id="contact_list_id"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                    <option value="">-- Add Contact --</option>
                    @foreach ($contactLists as $contactList)
                        @if (!empty($contactList) && isset($contactList->id))
                            <option value="{{ $contactList->id }}">{{ $contactList->email }}</option>
                        @endif
                    @endforeach
                </select>
                <x-primary-button class="mt-4">{{ __('Add Contact') }}</x-primary-button>
            </div>
        </form>
    </div>
</x-app-layout>
