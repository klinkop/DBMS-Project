<x-app-layout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
        <h2 class="text-lg font-bold mb-4">Create New Contact List</h2>

        <form method="POST" action="{{ route('contactList.store') }}">
            @csrf

            {{-- <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <textarea id="name" name="name"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"></textarea>
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div> --}}
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
                <label for="resources" class="block text-sm font-medium text-gray-700">Resources</label>
                <input id="resources" type="text" name="resources"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                <x-input-error :messages="$errors->get('resources')" class="mt-2" />
            </div>

            <div class="mb-4">
                <label for="status_id" class="block text-sm font-medium text-gray-700">Status</label>
                <select id="status_id" name="status_id"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                    <option value="">-- Select Status --</option>
                    @foreach ($statuses as $status)
                        @if (!empty($status) && isset($status->id))
                            <option value="{{ $status->id }}">{{ $status->name }}</option>
                        @endif
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('status_id')" class="mt-2" />
            </div>

            <div class="mb-4">
                <label for="type_id" class="block text-sm font-medium text-gray-700">Type</label>
                <select id="type_id" name="type_id"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                    <option value="">-- Select Type --</option>
                    @foreach ($types as $type)
                        @if (!empty($type) && isset($type->id))
                            <option value="{{ $type->id }}">{{ $type->name }}</option>
                        @endif
                    @endforeach
                </select>
                <x-input-error :messages="$errors->get('type_id')" class="mt-2" />
            </div>

            <div class="mb-4">
                <label for="industry" class="block text-sm font-medium text-gray-700">Industry</label>
                <input id="industry" type="text" name="industry"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                <x-input-error :messages="$errors->get('industry')" class="mt-2" />
            </div>

            <div class="mb-4">
                <label for="company" class="block text-sm font-medium text-gray-700">Company</label>
                <input id="company" type="text" name="company"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                <x-input-error :messages="$errors->get('company')" class="mt-2" />
            </div>

            <div class="mb-4">
                <label for="product" class="block text-sm font-medium text-gray-700">Product</label>
                <input id="product" type="text" name="product"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                <x-input-error :messages="$errors->get('product')" class="mt-2" />
            </div>

            <div class="mb-4">
                <label for="bgoc_product" class="block text-sm font-medium text-gray-700">BGOC Product</label>
                <input id="bgoc_product" type="text" name="bgoc_product"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                <x-input-error :messages="$errors->get('bgoc_product')" class="mt-2" />
            </div>

            <div class="mb-4">
                <label for="pic" class="block text-sm font-medium text-gray-700">PIC</label>
                <input id="pic" type="text" name="pic"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                <x-input-error :messages="$errors->get('pic')" class="mt-2" />
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
                <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                <input id="address" type="text" name="address"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                <x-input-error :messages="$errors->get('address')" class="mt-2" />
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

            <div class="mb-4">
                <label for="remarks" class="block text-sm font-medium text-gray-700">Remarks</label>
                <input id="remarks" type="text" name="remarks"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                <x-input-error :messages="$errors->get('remarks')" class="mt-2" />
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
