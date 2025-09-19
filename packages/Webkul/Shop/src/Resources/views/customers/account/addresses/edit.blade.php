<x-shop::layouts.account>
    <!-- Page Title -->
    <x-slot:title>
        @lang('shop::app.customers.account.addresses.edit.edit')
        @lang('shop::app.customers.account.addresses.edit.title') 
    </x-slot>

    <!-- Breadcrumbs -->
    @if ((core()->getConfigData('general.general.breadcrumbs.shop')))
        @section('breadcrumbs')
            <x-shop::breadcrumbs
                name="addresses.edit"
                :entity="$address"
            />
        @endSection
    @endif

    <div class="max-md:hidden">
        <x-shop::layouts.account.navigation />
    </div>

    <div class="mx-4 flex-auto max-md:mx-6 max-sm:mx-4">
        <div class="mb-8 flex items-center max-md:mb-5">
            <!-- Back Button -->
            <a
                class="grid md:hidden"
                href="{{ route('shop.customers.account.addresses.index') }}"
            >
                <span class="icon-arrow-left rtl:icon-arrow-right text-2xl"></span>
            </a>

            <h2 class="text-2xl font-medium max-sm:text-base ltr:ml-2.5 md:ltr:ml-0 rtl:mr-2.5 md:rtl:mr-0">
                @lang('shop::app.customers.account.addresses.edit.edit')
                @lang('shop::app.customers.account.addresses.edit.title')
            </h2>
        </div>

        {!! view_render_event('bagisto.shop.customers.account.address.edit.before', ['address' => $address]) !!}

        <!-- Customer Address edit Component-->
        <v-edit-customer-address>
            <!-- Address Shimmer -->
            <x-shop::shimmer.form.control-group :count="10" />
        </v-edit-customer-address>

        {!! view_render_event('bagisto.shop.customers.account.address.edit.after', ['address' => $address]) !!}
    </div>

    @pushOnce('styles')
        <style>
            /* Nova Poshta Select Styles */
            .nova-poshta-select {
                transition: all 0.2s ease-in-out;
            }
            
            .nova-poshta-select:hover:not(:disabled) {
                transform: translateY(-1px);
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            }
            
            .nova-poshta-select:focus {
                transform: translateY(-1px);
                box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15);
            }
            
            .nova-poshta-select:disabled {
                opacity: 0.6;
                cursor: not-allowed;
            }
            
            /* Loading animation */
            @keyframes spin {
                from { transform: rotate(0deg); }
                to { transform: rotate(360deg); }
            }
            
            .animate-spin {
                animation: spin 1s linear infinite;
            }
            
            /* Success state */
            .nova-poshta-select.success {
                border-color: #10b981;
                background-color: #f0fdf4;
            }
            
            /* Error state */
            .nova-poshta-select.error {
                border-color: #ef4444;
                background-color: #fef2f2;
            }
            
            /* Subtle fade in animation for options */
            .nova-poshta-option {
                animation: fadeIn 0.2s ease-out;
            }
            
            @keyframes fadeIn {
                from { opacity: 0; }
                to { opacity: 1; }
            }
        </style>
    @endPushOnce

    @push('scripts')
        <script
            type="text/x-template"
            id="v-edit-customer-address-template"
        >
            <!-- Edit Address Form -->
            <x-shop::form
                method="PUT"
                :action="route('shop.customers.account.addresses.update',  $address->id)"
            >
                {!! view_render_event('bagisto.shop.customers.account.address.edit_form_controls.before', ['address' => $address]) !!}

                <!-- Company Name -->
                <x-shop::form.control-group>
                    <x-shop::form.control-group.label>
                        @lang('shop::app.customers.account.addresses.edit.company-name')
                    </x-shop::form.control-group.label>

                    <x-shop::form.control-group.control
                        type="text"
                        name="company_name"
                        :value="old('company_name') ?? $address->company_name"
                        :label="trans('shop::app.customers.account.addresses.edit.company-name')"
                        :placeholder="trans('shop::app.customers.account.addresses.edit.company-name')"
                    />

                    <x-shop::form.control-group.error control-name="company_name" />
                </x-shop::form.control-group>

                {!! view_render_event('bagisto.shop.customers.account.addresses.edit_form_controls.company_name.after', ['address' => $address]) !!}

                <!-- First Name -->
                <x-shop::form.control-group>
                    <x-shop::form.control-group.label class="required">
                        @lang('shop::app.customers.account.addresses.edit.first-name')
                    </x-shop::form.control-group.label>

                    <x-shop::form.control-group.control
                        type="text"
                        name="first_name"
                        rules="required"
                        :value="old('first_name') ?? $address->first_name"
                        :label="trans('shop::app.customers.account.addresses.edit.first-name')"
                        :placeholder="trans('shop::app.customers.account.addresses.edit.first-name')"
                    />

                    <x-shop::form.control-group.error control-name="first_name" />
                </x-shop::form.control-group>

                {!! view_render_event('bagisto.shop.customers.account.addresses.edit_form_controls.first_name.after', ['address' => $address]) !!}

                <!-- Last Name -->
                <x-shop::form.control-group>
                    <x-shop::form.control-group.label class="required">
                        @lang('shop::app.customers.account.addresses.edit.last-name')
                    </x-shop::form.control-group.label>

                    <x-shop::form.control-group.control
                        type="text"
                        name="last_name"
                        rules="required"
                        :value="old('last_name') ?? $address->last_name"
                        :label="trans('shop::app.customers.account.addresses.edit.last-name')"
                        :placeholder="trans('shop::app.customers.account.addresses.edit.last-name')"
                    />

                    <x-shop::form.control-group.error control-name="last_name" />
                </x-shop::form.control-group>

                {!! view_render_event('bagisto.shop.customers.account.addresses.edit_form_controls.last_name.after', ['address' => $address]) !!}

                <!-- E-mail -->
                <x-shop::form.control-group>
                    <x-shop::form.control-group.label class="required">
                        @lang('Email')
                    </x-shop::form.control-group.label>

                    <x-shop::form.control-group.control
                        type="text"
                        name="email"
                        rules="required|email"
                        :value="old('email') ?? $address->email"
                        :label="trans('Email')"
                        :placeholder="trans('Email')"
                    />

                    <x-shop::form.control-group.error control-name="email" />
                </x-shop::form.control-group>

                {!! view_render_event('bagisto.shop.customers.account.addresses.edit_form_controls.email.after', ['address' => $address]) !!}

                <!-- Nova Poshta Area Selection -->
                <x-shop::form.control-group>
                    <x-shop::form.control-group.label class="required !mt-0">
                        Область
                    </x-shop::form.control-group.label>

                    <v-select
                        v-model="selectedArea"
                        :options="areaOptions"
                        :loading="areaLoading"
                        placeholder="Виберіть область"
                        searchable
                        clearable
                        close-on-select="false"
                        @input="onAreaChange"
                        @update:modelValue="onAreaChange"
                        class="nova-poshta-select"
                    />

                    <x-shop::form.control-group.error control-name="area" />
                </x-shop::form.control-group>

                <!-- Nova Poshta City Selection -->
                <x-shop::form.control-group>
                    <x-shop::form.control-group.label class="required !mt-0">
                        Місто
                    </x-shop::form.control-group.label>

                    <v-select
                        v-model="selectedCity"
                        :options="cityOptions"
                        :loading="cityLoading"
                        :disabled="!selectedArea"
                        placeholder="Спочатку виберіть область"
                        searchable
                        clearable
                        close-on-select="false"
                        @input="onCityChange"
                        @update:modelValue="onCityChange"
                        class="nova-poshta-select"
                    />

                    <x-shop::form.control-group.error control-name="city" />
                </x-shop::form.control-group>

                <!-- Nova Poshta Warehouse Selection -->
                <x-shop::form.control-group>
                    <x-shop::form.control-group.label class="required !mt-0">
                        Відділення Нової Пошти
                    </x-shop::form.control-group.label>

                    <v-select
                        v-model="selectedWarehouse"
                        :options="warehouseOptions"
                        :loading="warehouseLoading"
                        :disabled="!selectedCity"
                        placeholder="Спочатку виберіть місто"
                        searchable
                        clearable
                        close-on-select="false"
                        @input="onWarehouseChange"
                        @update:modelValue="onWarehouseChange"
                        class="nova-poshta-select"
                    />

                    <x-shop::form.control-group.error control-name="warehouse" />
                </x-shop::form.control-group>

                <!-- Hidden fields for Ukraine -->
                <x-shop::form.control-group class="hidden">
                    <x-shop::form.control-group.control
                        type="text"
                        name="country"
                        value="UA"
                    />
                    <x-shop::form.control-group.control
                        type="text"
                        name="state"
                        v-model="selectedAreaLabel"
                    />
                    <x-shop::form.control-group.control
                        type="text"
                        name="area"
                        v-model="selectedAreaLabel"
                    />
                    <x-shop::form.control-group.control
                        type="text"
                        name="city"
                        v-model="selectedCityLabel"
                    />
                    <x-shop::form.control-group.control
                        type="text"
                        name="warehouse"
                        v-model="selectedWarehouseLabel"
                    />
                </x-shop::form.control-group>

                <!-- Vat ID -->
                <x-shop::form.control-group>
                    <x-shop::form.control-group.label>
                        @lang('shop::app.customers.account.addresses.edit.vat-id')
                    </x-shop::form.control-group.label>

                    <x-shop::form.control-group.control
                        type="text"
                        name="vat_id"
                        :value="old('vat_id') ?? $address->vat_id"
                        :label="trans('shop::app.customers.account.addresses.edit.vat-id')"
                        :placeholder="trans('shop::app.customers.account.addresses.edit.vat-id')"
                    />

                    <x-shop::form.control-group.error control-name="vat_id" />
                </x-shop::form.control-group>

                {!! view_render_event('bagisto.shop.customers.account.addresses.edit_form_controls.vat_id.after', ['address' => $address]) !!}

                @php
                    $addresses = explode(PHP_EOL, $address->address);
                @endphp

                <!-- Street Address -->
                <x-shop::form.control-group>
                    <x-shop::form.control-group.label class="required">
                        @lang('shop::app.customers.account.addresses.edit.street-address')
                    </x-shop::form.control-group.label>

                    <x-shop::form.control-group.control
                        type="text"
                        name="address[]"
                        :value="collect(old('address'))->first() ?? $addresses[0]"
                        rules="required|address"
                        :label="trans('shop::app.customers.account.addresses.edit.street-address')"
                        :placeholder="trans('shop::app.customers.account.addresses.edit.street-address')"
                    />

                    <x-shop::form.control-group.error control-name="address[]" />
                </x-shop::form.control-group>

                @if (
                    core()->getConfigData('customer.address.information.street_lines')
                    && core()->getConfigData('customer.address.information.street_lines') > 1
                )
                    @for ($i = 1; $i < core()->getConfigData('customer.address.information.street_lines'); $i++)
                        <x-shop::form.control-group.control
                            type="text"
                            name="address[{{ $i }}]"
                            :value="old('address[{{$i}}]', $addresses[$i] ?? '')"
                            rules="address"
                            :label="trans('shop::app.customers.account.addresses.edit.street-address')"
                            :placeholder="trans('shop::app.customers.account.addresses.edit.street-address')"
                        />

                        <x-shop::form.control-group.error
                            class="mb-2"
                            name="address[{{ $i }}]"
                        />
                    @endfor
                @endif

                {!! view_render_event('bagisto.shop.customers.account.addresses.edit_form_controls.street-addres.after', ['address' => $address]) !!}

                <!-- Country Name -->
                <x-shop::form.control-group>
                    <x-shop::form.control-group.label class="{{ core()->isCountryRequired() ? 'required' : '' }}">
                        @lang('shop::app.customers.account.addresses.edit.country')
                    </x-shop::form.control-group.label>

                    <x-shop::form.control-group.control
                        type="select"
                        name="country"
                        rules="{{ core()->isStateRequired() ? 'required' : '' }}"
                        v-model="addressData.country"
                        :aria-label="trans('shop::app.customers.account.addresses.edit.country')"
                        :label="trans('shop::app.customers.account.addresses.edit.country')"
                    >
                        @foreach (core()->countries() as $country)
                            <option 
                                {{ $country->code === config('app.default_country') ? 'selected' : '' }}  
                                value="{{ $country->code }}"
                            >
                                {{ $country->name }}
                            </option>
                        @endforeach
                    </x-shop::form.control-group.control>

                    <x-shop::form.control-group.error control-name="country" />
                </x-shop::form.control-group>

                {!! view_render_event('bagisto.shop.customers.account.addresses.edit_form_controls.country.after', ['address' => $address]) !!}

                <!-- State Name -->
                <x-shop::form.control-group>
                    <x-shop::form.control-group.label class="{{ core()->isStateRequired() ? 'required' : '' }}">
                        @lang('shop::app.customers.account.addresses.edit.state')
                    </x-shop::form.control-group.label>
                    <template v-if="haveStates()">
                        <x-shop::form.control-group.control
                            type="select"
                            name="state"
                            id="state"
                            rules="{{ core()->isStateRequired() ? 'required' : '' }}"
                            v-model="addressData.state"
                            :label="trans('shop::app.customers.account.addresses.edit.state')"
                            :placeholder="trans('shop::app.customers.account.addresses.edit.state')"
                        >
                            <option 
                                v-for='(state, index) in countryStates[addressData.country]'
                                :value="state.code"
                            >
                                @{{ state.default_name }}
                            </option>
                        </x-shop::form.control-group.control>
                    </template>

                    <template v-else>
                        <x-shop::form.control-group.control
                            type="text"
                            name="state"
                            rules="{{ core()->isStateRequired() ? 'required' : '' }}"
                            :value="old('state') ?? $address->state"
                            :label="trans('shop::app.customers.account.addresses.edit.state')"
                            :placeholder="trans('shop::app.customers.account.addresses.edit.state')"
                        />
                    </template>

                    <x-shop::form.control-group.error control-name="state" />
                </x-shop::form.control-group>

                {!! view_render_event('bagisto.shop.customers.account.addresses.edit_form_controls.state.after', ['address' => $address]) !!}

                <x-shop::form.control-group>
                    <x-shop::form.control-group.label class="required">
                        @lang('shop::app.customers.account.addresses.edit.city')
                    </x-shop::form.control-group.label>

                    <x-shop::form.control-group.control
                        type="text"
                        name="city"
                        rules="required"
                        :value="old('city') ?? $address->city"
                        :label="trans('shop::app.customers.account.addresses.edit.city')"
                        :placeholder="trans('shop::app.customers.account.addresses.edit.city')"
                    />

                    <x-shop::form.control-group.error control-name="city" />
                </x-shop::form.control-group>

                {!! view_render_event('bagisto.shop.customers.account.addresses.edit_form_controls.city.after', ['address' => $address]) !!}

                <x-shop::form.control-group>
                    <x-shop::form.control-group.label class="{{ core()->isPostCodeRequired() ? 'required' : '' }}">
                        @lang('shop::app.customers.account.addresses.edit.post-code')
                    </x-shop::form.control-group.label>

                    <x-shop::form.control-group.control
                        type="text"
                        name="postcode"
                        rules="{{ core()->isPostCodeRequired() ? 'required' : '' }}|postcode"
                        :value="old('postal-code') ?? $address->postcode"
                        :label="trans('shop::app.customers.account.addresses.edit.post-code')"
                        :placeholder="trans('shop::app.customers.account.addresses.edit.post-code')"
                    />

                    <x-shop::form.control-group.error control-name="postcode" />
                </x-shop::form.control-group>

                {!! view_render_event('bagisto.shop.customers.account.addresses.edit_form_controls.postcode.after', ['address' => $address]) !!}

                <x-shop::form.control-group>
                    <x-shop::form.control-group.label class="required">
                        @lang('shop::app.customers.account.addresses.edit.phone')
                    </x-shop::form.control-group.label>

                    <x-shop::form.control-group.control
                        type="text"
                        name="phone"
                        rules="required|phone"
                        :value="old('phone') ?? $address->phone"
                        :label="trans('shop::app.customers.account.addresses.edit.phone')"
                        :placeholder="trans('shop::app.customers.account.addresses.edit.phone')"
                    />

                    <x-shop::form.control-group.error control-name="phone" />
                </x-shop::form.control-group>

                {!! view_render_event('bagisto.shop.customers.account.addresses.edit_form_controls.phone.after', ['address' => $address]) !!}

                <button
                    type="submit"
                    class="primary-button m-0 block rounded-2xl px-11 py-3 text-center text-base max-md:w-full max-md:max-w-full max-md:rounded-lg max-md:py-1.5"
                >
                    @lang('shop::app.customers.account.addresses.edit.update-btn')
                </button>
                
                {!! view_render_event('bagisto.shop.customers.account.address.edit_form_controls.after', ['address' => $address]) !!}

            </x-shop::form>
        </script>

        <script type="module">
            app.component('v-edit-customer-address', {
                template: '#v-edit-customer-address-template',

                data() {
                    return {
                        addressData: {
                            country: "{{ old('country') ?? $address->country }}",
                            state: "{{ old('state') ?? $address->state }}",
                        },
                        countryStates: {!! json_encode(core()->groupedStatesByCountries()) !!},
                        
                        // Nova Poshta data
                        selectedArea: null,
                        selectedCity: null,
                        selectedWarehouse: null,
                        areaOptions: [],
                        cityOptions: [],
                        warehouseOptions: [],
                        areaLoading: false,
                        cityLoading: false,
                        warehouseLoading: false,
                        selectedAreaLabel: '',
                        selectedCityLabel: '',
                        selectedWarehouseLabel: '',
                    };
                },

                mounted() {
                    // Initialize Nova Poshta form
                    this.initNovaPoshtaForm();
                },
    
                methods: {
                    haveStates() {
                        return !!this.countryStates[this.addressData.country]?.length;
                    },

                    initNovaPoshtaForm() {
                        console.log('Initializing Nova Poshta form for customer address editing');
                        // Load areas
                        this.loadAreas();
                    },

                    loadAreas() {
                        this.areaLoading = true;
                        
                        fetch("{{ route('api.nova-poshta.areas') }}")
                            .then(response => response.json())
                            .then(data => {
                                console.log('Areas response:', data);
                                if (data.success) {
                                    this.areaOptions = data.data.map(area => ({
                                        value: area.ref,
                                        label: area.description_ru || area.description
                                    }));
                                }
                            })
                            .catch(error => {
                                console.error('Error loading areas:', error);
                            })
                            .finally(() => {
                                this.areaLoading = false;
                            });
                    },

                    onAreaChange(option) {
                        console.log('Area changed to:', option.label);
                        console.log('AreaRef type:', typeof option.value);
                        console.log('AreaRef value:', option.value);
                        
                        // Reset dependent selects
                        this.selectedCity = null;
                        this.selectedWarehouse = null;
                        this.cityOptions = [];
                        this.warehouseOptions = [];
                        
                        if (option.value) {
                            console.log('Loading cities for area:', option.value);
                            this.loadCities(option.value);
                            document.querySelector('input[name="area"]').setAttribute('value', option.label);
                            document.querySelector('input[name="state"]').setAttribute('value', option.label);
                            this.selectedAreaLabel = option.label;
                        } else {
                            console.log('No area selected, not loading cities');
                        }
                    },

                    loadCities(areaRef) {
                        console.log('loadCities called with areaRef:', areaRef);
                        this.cityLoading = true;
                        
                        const url = `{{ route('api.nova-poshta.cities') }}?area_ref=${areaRef}`;
                        console.log('Fetching cities from URL:', url);
                        
                        fetch(url)
                            .then(response => {
                                console.log('Cities response status:', response.status);
                                return response.json();
                            })
                            .then(data => {
                                console.log('Cities response data:', data);
                                if (data.success) {
                                    this.cityOptions = data.data.map(city => ({
                                        value: city.ref,
                                        label: city.description_ru || city.description
                                    }));
                                    console.log('City options set:', this.cityOptions);
                                } else {
                                    console.error('API returned success: false', data);
                                }
                            })
                            .catch(error => {
                                console.error('Error loading cities:', error);
                            })
                            .finally(() => {
                                this.cityLoading = false;
                                console.log('City loading finished');
                            });
                    },

                    onCityChange(option) {
                        console.log('City changed to:', option.label);
                        
                        // Reset dependent select
                        this.selectedWarehouse = null;
                        this.warehouseOptions = [];
                        
                        if (option.value) {
                            this.loadWarehouses(option.value);
                            document.querySelector('input[name="city"]').setAttribute('value', option.label);
                            this.selectedCityLabel = option.label;
                        }
                    },

                    loadWarehouses(cityRef) {
                        this.warehouseLoading = true;
                        
                        fetch(`{{ route('api.nova-poshta.warehouses') }}?city_ref=${cityRef}`)
                            .then(response => response.json())
                            .then(data => {
                                console.log('Warehouses response:', data);
                                if (data.success) {
                                    this.warehouseOptions = data.data.map(warehouse => ({
                                        value: warehouse.ref,
                                        label: warehouse.description_ru || warehouse.description
                                    }));
                                }
                            })
                            .catch(error => {
                                console.error('Error loading warehouses:', error);
                            })
                            .finally(() => {
                                this.warehouseLoading = false;
                            });
                    },

                    onWarehouseChange(option) {
                        console.log('Warehouse changed to:', option.label);
                        console.log('Warehouse value:', document.querySelector('input[name="warehouse"]').value);
                        document.querySelector('input[name="warehouse"]').setAttribute('value', option.label);
                        console.log('Warehouse value:', document.querySelector('input[name="warehouse"]').value);
                        this.selectedWarehouseLabel = option.label;
                    },

                },
            });
        </script>
    @endpush

</x-shop::layouts.account>
