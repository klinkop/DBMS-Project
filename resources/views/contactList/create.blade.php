<x-layout>

    <x-navbars.sidebar activePage='contactList'></x-navbars.sidebar>

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">

    <x-navbars.navs.auth titlePage="Create Contacts"></x-navbars.navs.auth>

    <div class="container-fluid px-2 px-md-4">

            <div class="page-header min-height-300 border-radius-xl mt-4"
                style="background-image: url('https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');">
                <span class="mask  bg-gradient-primary  opacity-6"></span>
            </div>
            <div class="card card-body mx-3 mx-md-4 mt-n9">
                <div class="card card-plain h-100">
                    <div class="card-header pb-0 p-3">
                        <div class="row">
                            <div class="col-md-8 d-flex align-items-center">
                                <h6 class="mb-3 col-md-6">Create Contact</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-3">
                        <form method="POST" action="{{ route('contactList.store') }}">
                            @csrf
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="resources" class="form-label">Resources</label>
                                    <input id="resources" type="text" name="resources"
                                        class="form-control border border-2 p-2">
                                    <x-input-error :messages="$errors->get('resources')" class="mt-2" />
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="status_id" class="form-label">Status</label>
                                    <select id="status_id" name="status_id"
                                        class="form-control border border-2 p-2">
                                        <option value="">-- Select Status --</option>
                                        @foreach ($statuses as $status)
                                            @if (!empty($status) && isset($status->id))
                                                <option value="{{ $status->id }}">{{ $status->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('status_id')" class="mt-2" />
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="type_id" class="form-label">Type</label>
                                    <select id="type_id" name="type_id"
                                        class="form-control border border-2 p-2">
                                        <option value="">-- Select Type --</option>
                                        @foreach ($types as $type)
                                            @if (!empty($type) && isset($type->id))
                                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('type_id')" class="mt-2" />
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="industry" class="form-label">Industry</label>
                                    <input id="industry" type="text" name="industry"
                                        class="form-control border border-2 p-2">
                                    <x-input-error :messages="$errors->get('industry')" class="mt-2" />
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="company" class="form-label">Company</label>
                                    <input id="company" type="text" name="company"
                                        class="form-control border border-2 p-2">
                                    <x-input-error :messages="$errors->get('company')" class="mt-2" />
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="product" class="form-label">Product</label>
                                    <input id="product" type="text" name="product"
                                        class="form-control border border-2 p-2">
                                    <x-input-error :messages="$errors->get('product')" class="mt-2" />
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="bgoc_product" class="form-label">BGOC Product</label>
                                    <input id="bgoc_product" type="text" name="bgoc_product"
                                        class="form-control border border-2 p-2">
                                    <x-input-error :messages="$errors->get('bgoc_product')" class="mt-2" />
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="pic" class="form-label">PIC</label>
                                    <input id="pic" type="text" name="pic"
                                        class="form-control border border-2 p-2">
                                    <x-input-error :messages="$errors->get('pic')" class="mt-2" />
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="email" class="form-label">Email</label>
                                    <input id="email" type="text" name="email"
                                        class="form-control border border-2 p-2">
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="contact1" class="form-label">Contact 1</label>
                                    <input id="contact1" type="text" name="contact1"
                                        class="form-control border border-2 p-2">
                                    <x-input-error :messages="$errors->get('contact1')" class="mt-2" />
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="contact2" class="form-label">Contact 2</label>
                                    <input id="contact2" type="text" name="contact2"
                                        class="form-control border border-2 p-2">
                                    <x-input-error :messages="$errors->get('contact2')" class="mt-2" />
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="address" class="form-label">Address</label>
                                    <input id="address" type="text" name="address"
                                        class="form-control border border-2 p-2">
                                    <x-input-error :messages="$errors->get('address')" class="mt-2" />
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="state_id" class="form-label">State</label>
                                    <select id="state_id" name="state_id"
                                        class="form-control border border-2 p-2"
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

                                <div class="mb-3 col-md-6">
                                    <label for="city_id" class="form-label">City</label>
                                    <select id="city_id" name="city_id"
                                        class="form-control border border-2 p-2">
                                        <option value="">-- Select a City --</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('city_id')" class="mt-2" />
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="remarks" class="form-label">Remarks</label>
                                    <input id="remarks" type="text" name="remarks"
                                        class="form-control border border-2 p-2">
                                    <x-input-error :messages="$errors->get('remarks')" class="mt-2" />
                                </div>
                            </div>
                            {{-- hidden input: subFolder id --}}
                            <input type="hidden" name="sub_folder_id" value="{{ $subFolder->id }}" />

                            <div class="mt-4 space-x-2">
                                <x-primary-button>{{ __('Create') }}</x-primary-button>
                                <button type="button" onclick="history.back()"
                                    class="btn btn-danger">
                                    Cancel
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </div>
    <div class="botts"><x-footers.auth></x-footers.auth></div>
    </main>
    <x-plugins></x-plugins>
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
