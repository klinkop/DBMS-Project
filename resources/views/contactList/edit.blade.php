<x-layout>

    <x-navbars.sidebar activePage='contactList'></x-navbars.sidebar>

    <main class="main-content position-relative min-height-vh-100 h-100 border-radius-lg ">

    <x-navbars.navs.auth titlePage="Edit Contacts"></x-navbars.navs.auth>


    <div class="container-fluid px-2 px-md-4">
        <div class="page-header min-height-300 border-radius-xl mt-4"
                style="background-image: url('https://images.unsplash.com/photo-1531512073830-ba890ca4eba2?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=1920&q=80');">
                <span class="mask  bg-gradient-primary  opacity-6"></span>
        </div>
        <div class="card card-body mx-3 mx-md-4 mt-n9">
            <div class="card card-plain h-100">
                <div class="card-header pb-0 p-3">
                    <div class="row d-flex justify-content-between">
                        <div class="col-md-8 d-flex align-items-center">
                            <h6 class="mb-1 col-md-6">Edit Contact</h6>
                        </div>
                        <div class="d-flex align-items-center" style="width: auto;">
                            <button type="button" onclick="window.history.back()" class="btn bg-gradient-dark" style="margin-left: 20px; margin-top: 20px;">
                                {{ __('Back') }}
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-body p-3">
                    <form method="POST" action="{{ route('contactList.update', $contactList) }}">
                        @csrf
                        @method('patch')

                        <input type="hidden" name="subFolderId" value="{{ $subFolderId }}">

                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="resources" class="form-label">Resources</label>
                                <input id="resources" type="text" name="resources"
                                    class="form-control border border-2 p-2"
                                    value="{{ old('resources', $contactList->resources) }}">
                                <x-input-error :messages="$errors->get('resources')" class="mt-2" />
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="status_id" class="form-label">Status</label>
                                <select id="status_id" name="status_id"
                                    class="form-control border border-2 p-2"
                                    onchange="filterCities(this.value)">
                                    <option value="">-- Select Status --</option>
                                    @foreach ($statuses as $status)
                                        @if (!empty($status) && isset($status->id))
                                            <option value="{{ $status->id }}"
                                                {{ old('status_id', $contactList->status_id) == $status->id ? 'selected' : '' }}>
                                                {{ $status->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('status_id')" class="mt-2" />
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="type_id" class="form-label">Type</label>
                                <select id="type_id" name="type_id"
                                    class="form-control border border-2 p-2"
                                    onchange="filterCities(this.value)">
                                    <option value="">-- Select Type --</option>
                                    @foreach ($types as $type)
                                        @if (!empty($types) && isset($type->id))
                                            <option value="{{ $type->id }}"
                                                {{ old('type_id', $contactList->type_id) == $type->id ? 'selected' : '' }}>
                                                {{ $type->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('type_id')" class="mt-2" />
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="industry" class="form-label">Industry</label>
                                <input id="industry" type="text" name="industry"
                                    class="form-control border border-2 p-2"
                                    value="{{ old('industry', $contactList->industry) }}">
                                <x-input-error :messages="$errors->get('industry')" class="mt-2" />
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="company" class="form-label">Company</label>
                                <input id="company" type="text" name="company"
                                    class="form-control border border-2 p-2"
                                    value="{{ old('company', $contactList->company) }}">
                                <x-input-error :messages="$errors->get('company')" class="mt-2" />
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="product" class="form-label">Product</label>
                                <input id="product" type="text" name="product"
                                    class="form-control border border-2 p-2"
                                    value="{{ old('product', $contactList->product) }}">
                                <x-input-error :messages="$errors->get('product')" class="mt-2" />
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="bgoc_product" class="form-label">BGOC Product</label>
                                <input id="bgoc_product" type="text" name="bgoc_product"
                                    class="form-control border border-2 p-2"
                                    value="{{ old('bgoc_product', $contactList->bgoc_product) }}">
                                <x-input-error :messages="$errors->get('bgoc_product')" class="mt-2" />
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="pic" class="form-label">PIC</label>
                                <input id="pic" type="text" name="pic"
                                    class="form-control border border-2 p-2"
                                    value="{{ old('pic', $contactList->pic) }}">
                                <x-input-error :messages="$errors->get('pic')" class="mt-2" />
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input id="email" type="text" name="email"
                                    class="form-control border border-2 p-2"
                                    value="{{ old('email', $contactList->email) }}">
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="contact1" class="form-label">Contact 1</label>
                                <input id="contact1" type="text" name="contact1"
                                    class="form-control border border-2 p-2"
                                    value="{{ old('contact1', $contactList->contact1) }}">
                                <x-input-error :messages="$errors->get('contact1')" class="mt-2" />
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="contact2" class="form-label">Contact 2</label>
                                <input id="contact2" type="text" name="contact2"
                                    class="form-control border border-2 p-2"
                                    value="{{ old('contact2', $contactList->contact2) }}">
                                <x-input-error :messages="$errors->get('contact2')" class="mt-2" />
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="address" class="form-label">Address</label>
                                <input id="address" type="text" name="address"
                                    class="form-control border border-2 p-2"
                                    value="{{ old('address', $contactList->address) }}">
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
                                            <option value="{{ $state->id }}"
                                                {{ old('state_id', $contactList->state_id) == $state->id ? 'selected' : '' }}>
                                                {{ $state->name }}</option>
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
                                    @foreach ($cities as $city)
                                        @if (!empty($city) && isset($city->id) && $city->state_id == old('state_id', $contactList->state_id))
                                            <option value="{{ $city->id }}"
                                                {{ old('city_id', $contactList->city_id) == $city->id ? 'selected' : '' }}>
                                                {{ $city->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('city_id')" class="mt-2" />
                            </div>

                            <div class="mb-3 col-md-6">
                                <label for="remarks" class="form-label">Remarks</label>
                                <input id="remarks" type="text" name="remarks"
                                    class="form-control border border-2 p-2"
                                    value="{{ old('remarks', $contactList->remarks) }}">
                                <x-input-error :messages="$errors->get('remarks')" class="mt-2" />
                            </div>

                            <div class="flex justify-end">
                                <x-primary-button>{{ __('Save') }}</x-primary-button>
                                <a href="{{ route('contactList.index', ['subFolder' => $subFolderId]) }}" class="ml-4">{{ __('Cancel') }}</a>
                            </div>
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

    @push('js')
    <script src="{{ asset('assets') }}/js/plugins/chartjs.min.js"></script>
    <script>
        var ctx = document.getElementById("chart-bars").getContext("2d");

        new Chart(ctx, {
            type: "bar",
            data: {
                labels: ["M", "T", "W", "T", "F", "S", "S"],
                datasets: [{
                    label: "Sales",
                    tension: 0.4,
                    borderWidth: 0,
                    borderRadius: 4,
                    borderSkipped: false,
                    backgroundColor: "rgba(255, 255, 255, .8)",
                    data: [50, 20, 10, 22, 50, 10, 40],
                    maxBarThickness: 6
                }, ],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                scales: {
                    y: {
                        grid: {
                            drawBorder: false,
                            display: true,
                            drawOnChartArea: true,
                            drawTicks: false,
                            borderDash: [5, 5],
                            color: 'rgba(255, 255, 255, .2)'
                        },
                        ticks: {
                            suggestedMin: 0,
                            suggestedMax: 500,
                            beginAtZero: true,
                            padding: 10,
                            font: {
                                size: 14,
                                weight: 300,
                                family: "Roboto",
                                style: 'normal',
                                lineHeight: 2
                            },
                            color: "#fff"
                        },
                    },
                    x: {
                        grid: {
                            drawBorder: false,
                            display: true,
                            drawOnChartArea: true,
                            drawTicks: false,
                            borderDash: [5, 5],
                            color: 'rgba(255, 255, 255, .2)'
                        },
                        ticks: {
                            display: true,
                            color: '#f8f9fa',
                            padding: 10,
                            font: {
                                size: 14,
                                weight: 300,
                                family: "Roboto",
                                style: 'normal',
                                lineHeight: 2
                            },
                        }
                    },
                },
            },
        });


        var ctx2 = document.getElementById("chart-line").getContext("2d");

        new Chart(ctx2, {
            type: "line",
            data: {
                labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [{
                    label: "Mobile apps",
                    tension: 0,
                    borderWidth: 0,
                    pointRadius: 5,
                    pointBackgroundColor: "rgba(255, 255, 255, .8)",
                    pointBorderColor: "transparent",
                    borderColor: "rgba(255, 255, 255, .8)",
                    borderColor: "rgba(255, 255, 255, .8)",
                    borderWidth: 4,
                    backgroundColor: "transparent",
                    fill: true,
                    data: [50, 40, 300, 320, 500, 350, 200, 230, 500],
                    maxBarThickness: 6

                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                scales: {
                    y: {
                        grid: {
                            drawBorder: false,
                            display: true,
                            drawOnChartArea: true,
                            drawTicks: false,
                            borderDash: [5, 5],
                            color: 'rgba(255, 255, 255, .2)'
                        },
                        ticks: {
                            display: true,
                            color: '#f8f9fa',
                            padding: 10,
                            font: {
                                size: 14,
                                weight: 300,
                                family: "Roboto",
                                style: 'normal',
                                lineHeight: 2
                            },
                        }
                    },
                    x: {
                        grid: {
                            drawBorder: false,
                            display: false,
                            drawOnChartArea: false,
                            drawTicks: false,
                            borderDash: [5, 5]
                        },
                        ticks: {
                            display: true,
                            color: '#f8f9fa',
                            padding: 10,
                            font: {
                                size: 14,
                                weight: 300,
                                family: "Roboto",
                                style: 'normal',
                                lineHeight: 2
                            },
                        }
                    },
                },
            },
        });

        var ctx3 = document.getElementById("chart-line-tasks").getContext("2d");

        new Chart(ctx3, {
            type: "line",
            data: {
                labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [{
                    label: "Mobile apps",
                    tension: 0,
                    borderWidth: 0,
                    pointRadius: 5,
                    pointBackgroundColor: "rgba(255, 255, 255, .8)",
                    pointBorderColor: "transparent",
                    borderColor: "rgba(255, 255, 255, .8)",
                    borderWidth: 4,
                    backgroundColor: "transparent",
                    fill: true,
                    data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
                    maxBarThickness: 6

                }],
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false,
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index',
                },
                scales: {
                    y: {
                        grid: {
                            drawBorder: false,
                            display: true,
                            drawOnChartArea: true,
                            drawTicks: false,
                            borderDash: [5, 5],
                            color: 'rgba(255, 255, 255, .2)'
                        },
                        ticks: {
                            display: true,
                            padding: 10,
                            color: '#f8f9fa',
                            font: {
                                size: 14,
                                weight: 300,
                                family: "Roboto",
                                style: 'normal',
                                lineHeight: 2
                            },
                        }
                    },
                    x: {
                        grid: {
                            drawBorder: false,
                            display: false,
                            drawOnChartArea: false,
                            drawTicks: false,
                            borderDash: [5, 5]
                        },
                        ticks: {
                            display: true,
                            color: '#f8f9fa',
                            padding: 10,
                            font: {
                                size: 14,
                                weight: 300,
                                family: "Roboto",
                                style: 'normal',
                                lineHeight: 2
                            },
                        }
                    },
                },
            },
        });

    </script>
    @endpush
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
