<x-shop::layouts.account>
    <!-- Page Title -->
    <x-slot:title>
        @lang('shop::app.customers.account.addresses.create.add-address')
    </x-slot>

    <!-- Breadcrumbs -->
    @if ((core()->getConfigData('general.general.breadcrumbs.shop')))
        @section('breadcrumbs')
            <x-shop::breadcrumbs name="addresses.create" />
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

            <h2 class="text-2xl font-medium max-md:text-xl max-sm:text-base ltr:ml-2.5 md:ltr:ml-0 rtl:mr-2.5 md:rtl:mr-0">
                @lang('shop::app.customers.account.addresses.create.add-address')
            </h2>
        </div>

        <v-create-customer-address>
            <!--Address Shimmer-->
            <x-shop::shimmer.form.control-group :count="10" />
        </v-create-customer-address>

    </div>

    @pushOnce('styles')
        <style>
            
            .nova-poshta-select:hover:not(:disabled) {
                transform: translateY(-1px);
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
                z-index: 1000;
            }

            /* Keep dropdown open when hovering over it */
            .vs__dropdown-menu {
                z-index: 9999 !important;
                position: absolute !important;
                background: white !important;
                border: 1px solid #e5e7eb !important;
                border-radius: 8px !important;
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15) !important;
                max-height: 300px !important;
                overflow-y: auto !important;
                margin-top: 4px !important;
            }

            .vs__dropdown-menu:hover {
                z-index: 9999 !important;
            }

            /* v-select control styles */
            .vs__control {
                min-height: 48px !important;
                border: 1px solid #d1d5db !important;
                border-radius: 8px !important;
                background: white !important;
                transition: all 0.2s ease !important;
            }

            .vs__control:hover {
                border-color: #9ca3af !important;
            }

            .vs__control--focused {
                border-color: #3b82f6 !important;
                box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1) !important;
            }

            .vs__control--disabled {
                background-color: #f9fafb !important;
                border-color: #e5e7eb !important;
                color: #9ca3af !important;
            }

            /* v-select dropdown options */
            .vs__dropdown-option {
                padding: 12px 16px !important;
                transition: all 0.2s ease !important;
                border-bottom: 1px solid #f3f4f6 !important;
            }

            .vs__dropdown-option:last-child {
                border-bottom: none !important;
            }

            .vs__dropdown-option:hover {
                background-color: #f8fafc !important;
                color: #1f2937 !important;
            }

            .vs__dropdown-option--highlight {
                background-color: #3b82f6 !important;
                color: white !important;
            }

            .vs__dropdown-option--selected {
                background-color: #dbeafe !important;
                color: #1e40af !important;
                font-weight: 500 !important;
            }

            /* v-select search input */
            .vs__search {
                padding: 12px 16px !important;
                font-size: 14px !important;
                border: none !important;
                outline: none !important;
                background: transparent !important;
            }

            .vs__search::placeholder {
                color: #9ca3af !important;
            }

            /* v-select clear button */
            .vs__clear {
                color: #9ca3af !important;
                transition: color 0.2s ease !important;
            }

            .vs__clear:hover {
                color: #6b7280 !important;
            }

            /* v-select open indicator */
            .vs__open-indicator {
                color: #9ca3af !important;
                transition: all 0.2s ease !important;
            }

            .vs__open-indicator:hover {
                color: #6b7280 !important;
            }

        </style>
    @endPushOnce

    @push('scripts')
        <script
            type="text/x-template"
            id="v-create-customer-address-template"
        >
            <div>
                <x-shop::form :action="route('shop.customers.account.addresses.store')">
                    {!! view_render_event('bagisto.shop.customers.account.addresses.create_form_controls.before') !!}

                    <!-- First Name and Last Name in Grid -->
                    <div class="grid grid-cols-2 gap-x-5 max-md:grid-cols-1">
                        <!-- First Name -->
                        <x-shop::form.control-group>
                            <x-shop::form.control-group.label class="required !mt-0">
                                @lang('shop::app.customers.account.addresses.create.first-name')
                            </x-shop::form.control-group.label>

                            <x-shop::form.control-group.control
                                type="text"
                                name="first_name"
                                rules="required"
                                :value="old('first_name')"
                                :label="trans('shop::app.customers.account.addresses.create.first-name')"
                                :placeholder="trans('shop::app.customers.account.addresses.create.first-name')"
                            />

                            <x-shop::form.control-group.error control-name="first_name" />
                        </x-shop::form.control-group>

                        {!! view_render_event('bagisto.shop.customers.account.addresses.create_form_controls.first_name.after') !!}

                        <!-- Last Name -->
                        <x-shop::form.control-group>
                            <x-shop::form.control-group.label class="required !mt-0">
                                @lang('shop::app.customers.account.addresses.create.last-name')
                            </x-shop::form.control-group.label>

                            <x-shop::form.control-group.control
                                type="text"
                                name="last_name"
                                rules="required"
                                :value="old('last_name')"
                                :label="trans('shop::app.customers.account.addresses.create.last-name')"
                                :placeholder="trans('shop::app.customers.account.addresses.create.last-name')"
                            />

                            <x-shop::form.control-group.error control-name="last_name" />
                        </x-shop::form.control-group>

                        {!! view_render_event('bagisto.shop.customers.account.addresses.create_form_controls.last_name.after') !!}
                    </div>

                    <!-- E-mail -->
                    <x-shop::form.control-group>
                        <x-shop::form.control-group.label class="required !mt-0">
                            @lang('shop::app.customers.account.addresses.create.email')
                        </x-shop::form.control-group.label>

                        <x-shop::form.control-group.control
                            type="email"
                            name="email"
                            rules="required|email"
                            :value="old('email')"
                            :label="trans('shop::app.customers.account.addresses.create.email')"
                            placeholder="email@example.com"
                        />

                        <x-shop::form.control-group.error control-name="email" />
                    </x-shop::form.control-group>

                    {!! view_render_event('bagisto.shop.customers.account.addresses.create_form_controls.email.after') !!}

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

                    <!-- Hidden fields for compatibility -->
                    <x-shop::form.control-group class="hidden">
                        <x-shop::form.control-group.control
                            type="text"
                            name="address[]"
                            :value="collect(old('address'))->first()"
                        />
                    </x-shop::form.control-group>

                    {!! view_render_event('bagisto.shop.customers.account.addresses.create_form_controls.street_address.after') !!}

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

                    <!-- Post Code (optional for Nova Poshta) -->
                    <x-shop::form.control-group>
                        <x-shop::form.control-group.label class="!mt-0">
                            @lang('shop::app.customers.account.addresses.create.post-code')
                        </x-shop::form.control-group.label>

                        <x-shop::form.control-group.control
                            type="text"
                            name="postcode"
                            rules="postcode"
                            :value="old('postcode')"
                            :label="trans('shop::app.customers.account.addresses.create.post-code')"
                            :placeholder="trans('shop::app.customers.account.addresses.create.post-code')"
                        />

                        <x-shop::form.control-group.error control-name="postcode" />
                    </x-shop::form.control-group>

                    {!! view_render_event('bagisto.shop.customers.account.addresses.create_form_controls.postcode.after') !!}

                    <!-- Phone Number -->
                    <x-shop::form.control-group>
                        <x-shop::form.control-group.label class="required !mt-0">
                            @lang('shop::app.customers.account.addresses.create.phone')
                        </x-shop::form.control-group.label>

                        <x-shop::form.control-group.control
                            type="text"
                            name="phone"
                            rules="required|phone"
                            :value="old('phone')"
                            :label="trans('shop::app.customers.account.addresses.create.phone')"
                            :placeholder="trans('shop::app.customers.account.addresses.create.phone')"
                        />

                        <x-shop::form.control-group.error control-name="phone" />
                    </x-shop::form.control-group>

                    {!! view_render_event('bagisto.shop.customers.account.addresses.create_form_controls.phone.after') !!}

                    <!-- Set As Default -->
                    <div class="text-md mb-4 flex select-none items-center gap-x-1.5 text-zinc-500">
                        <input
                            type="checkbox"
                            name="default_address"
                            value="1"
                            id="default_address"
                            class="peer hidden cursor-pointer"
                        >

                        <label
                            class="icon-uncheck peer-checked:icon-check-box cursor-pointer text-2xl text-navyBlue peer-checked:text-navyBlue"
                            for="default_address"
                        >
                        </label>

                        <label 
                            class="block cursor-pointer text-base max-md:text-sm"
                            for="default_address"
                        >
                            @lang('shop::app.customers.account.addresses.create.set-as-default')
                        </label>
                    </div>

                    <button
                        type="submit"
                        class="primary-button m-0 block rounded-2xl px-11 py-3 text-center text-base max-md:w-full max-md:max-w-full max-md:rounded-lg max-md:py-2 max-sm:py-1.5"
                    >
                        @lang('shop::app.customers.account.addresses.create.save')
                    </button>

                    {!! view_render_event('bagisto.shop.customers.account.addresses.create_form_controls.after') !!}
                </x-shop::form>
                {!! view_render_event('bagisto.shop.customers.account.address.create.after') !!}
            </div>
        </script>
    
        <script>
            window.customerAddressData = {
                country: "{{ old('country') }}",
                state: "{{ old('state') }}",
                countryStates: {!! json_encode(core()->groupedStatesByCountries()) !!}
            };
        </script>

        <script type="module">
            app.component('v-create-customer-address', {
                template: '#v-create-customer-address-template',
    
                data() {
                    return {
                        country: window.customerAddressData.country,
                        state: window.customerAddressData.state,
                        countryStates: window.customerAddressData.countryStates,
                        
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
                    }
                },

                mounted() {
                    // Initialize Nova Poshta form
                    this.initNovaPoshtaForm();
                    
                    // Fix dropdown z-index issues
                    this.fixDropdownZIndex();
                },

                computed: {

                },
    
                methods: {
                    haveStates() {
                        /*
                        * The double negation operator is used to convert the value to a boolean.
                        * It ensures that the final result is a boolean value,
                        * true if the array has a length greater than 0, and otherwise false.
                        */
                        return !!this.countryStates[this.country]?.length;
                    },

                    initNovaPoshtaForm() {
                        console.log('Initializing Nova Poshta form for customer address creation');
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
                    
                    fixDropdownZIndex() {
                        // Wait for DOM to be ready
                        this.$nextTick(() => {
                            // Find all v-select dropdowns and fix their z-index
                            const observer = new MutationObserver((mutations) => {
                                mutations.forEach((mutation) => {
                                    if (mutation.type === 'childList') {
                                        const dropdowns = document.querySelectorAll('.vs__dropdown-menu');
                                        dropdowns.forEach((dropdown) => {
                                            dropdown.style.zIndex = '9999';
                                            dropdown.style.position = 'absolute';
                                            
                                            // Prevent dropdown from closing when hovering over it
                                            dropdown.addEventListener('mouseenter', (e) => {
                                                e.stopPropagation();
                                            });
                                            
                                            dropdown.addEventListener('mouseleave', (e) => {
                                                e.stopPropagation();
                                            });
                                        });
                                    }
                                });
                            });
                            
                            // Start observing
                            observer.observe(document.body, {
                                childList: true,
                                subtree: true
                            });
                            
                            // Also fix existing dropdowns
                            setTimeout(() => {
                                const dropdowns = document.querySelectorAll('.vs__dropdown-menu');
                                dropdowns.forEach((dropdown) => {
                                    dropdown.style.zIndex = '9999';
                                    dropdown.style.position = 'absolute';
                                    
                                    // Prevent dropdown from closing when hovering over it
                                    dropdown.addEventListener('mouseenter', (e) => {
                                        e.stopPropagation();
                                    });
                                    
                                    dropdown.addEventListener('mouseleave', (e) => {
                                        e.stopPropagation();
                                    });
                                });
                            }, 100);
                        });
                    }
                }
            });
        </script>
    @endpush

</x-shop::layouts.account>
