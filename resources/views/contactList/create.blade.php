<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <h2 class="text-lg font-bold mb-4">Create New Contact List</h2>

        <form method="POST" action="{{ route('contactList.store') }}">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <textarea id="name" name="name"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"></textarea>
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>
            {{--
            <div class="mb-4">
                <label for="sub_folder" class="block text-sm font-medium text-gray-700">Sub Folder</label>
                <select name="sub_folder_id" id="sub_folder_id"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                    @foreach ($subFolders as $subFolder)
                        <option value="{{ $subFolder->id }}">{{ $subFolder->name }}</option>
                    @endforeach
                </select>
            </div> --}}

            <div class="mb-4">
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <input id="status" type="text" name="status"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                <x-input-error :messages="$errors->get('status')" class="mt-2" />
            </div>

            <div class="mb-4">
                <label for="pic" class="block text-sm font-medium text-gray-700">PIC</label>
                <input id="pic" type="text" name="pic"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                <x-input-error :messages="$errors->get('pic')" class="mt-2" />
            </div>

            <div class="mb-4">
                <label for="company" class="block text-sm font-medium text-gray-700">Company</label>
                <input id="company" type="text" name="company"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                <x-input-error :messages="$errors->get('company')" class="mt-2" />
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input id="email" type="text" name="email"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="mb-4">
                <label for="contact1" class="block text-sm font-medium text-gray-700">Contact 1</label>
                <input id="contact1" type="text" name="contact1"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                <x-input-error :messages="$errors->get('contact1')" class="mt-2" />
            </div>

            <div class="mb-4">
                <label for="contact2" class="block text-sm font-medium text-gray-700">Contact 2</label>
                <input id="contact2" type="text" name="contact2"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                <x-input-error :messages="$errors->get('contact2')" class="mt-2" />
            </div>

            <div class="mb-4">
                <label for="industry" class="block text-sm font-medium text-gray-700">Industry</label>
                <input id="industry" type="text" name="industry"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                <x-input-error :messages="$errors->get('industry')" class="mt-2" />
            </div>

            <div class="mb-4">
                <label for="state_id" class="block text-sm font-medium text-gray-700">State</label>
                <select id="state_id" name="state_id"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                    onchange="filterCities(this.value)">
                    <option value="">-- Select a State --</option>
                    @foreach ($states as $state)
                        @if (!empty($state) && isset($state->id))
                            <option value="{{ $state->id }}">{{ $state->name }}</option>
                        @endif
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('state_id')" class="mt-2" />
            </div>

            <div class="mb-4">
                <label for="city_id" class="block text-sm font-medium text-gray-700">City</label>
                <select id="city_id" name="city_id"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                    <option value="">-- Select a City --</option>
                </select>
                <x-input-error :messages="$errors->get('city_id')" class="mt-2" />
            </div>

            {{-- hidden input: subFolder id --}}
            <input type="hidden" name="sub_folder_id" value="{{ $subFolder->id }}" />

            <div class="mt-4 space-x-2">
                <x-primary-button>{{ __('Create') }}</x-primary-button>
                <a href="{{ route('contactList.index') }}">{{ __('Cancel') }}</a>
            </div>
        </form>
    </div>

    <script>
        let cities = @json($cities);

        function filterCities(state_id) {
            let citySelect = document.getElementById('city_id');
            citySelect.innerHTML = '<option value="">-- Select a City --</option>';

            cities.forEach(cities => {
                if (cities.state_id === parseInt(state_id)) {
                    let option = document.createElement('option');
                    option.value = cities.id;
                    option.text = cities.name;
                    citySelect.appendChild(option);
                }
            });
        }
    </script>
</x-app-layout>
