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
            id="v-edit-customer-address-template"
        >
            <!-- Edit Address Form -->
            <x-shop::form
                method="PUT"
                :action="route('shop.customers.account.addresses.update',  $address->id)"
            >
                {!! view_render_event('bagisto.shop.customers.account.address.edit_form_controls.before', ['address' => $address]) !!}


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

                <!-- Hidden fields for compatibility -->
                <x-shop::form.control-group class="hidden">
                    <x-shop::form.control-group.control
                        type="text"
                        name="address[]"
                        :value="collect(old('address'))->first() ?? $address->address"
                    />
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
                        v-model="area"
                    />
                    <x-shop::form.control-group.control
                        type="text"
                        name="area"
                        v-model="area"
                    />
                    <x-shop::form.control-group.control
                        type="text"
                        name="city"
                        v-model="city"
                    />
                    <x-shop::form.control-group.control
                        type="text"
                        name="warehouse"
                        v-model="warehouse"
                    />
                </x-shop::form.control-group>





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
                        area: '',
                        city: '',
                        warehouse: '',
                    };
                },

                mounted() {
                    // Initialize Nova Poshta form
                    this.initNovaPoshtaForm();
                    this.fixDropdownZIndex();
                },
    
                methods: {
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
                        
                        // Reset dependent selects
                        this.selectedCity = null;
                        this.selectedWarehouse = null;
                        this.cityOptions = [];
                        this.warehouseOptions = [];
                        
                        if (option.value) {
                            console.log('Loading cities for area:', option.value);
                            this.loadCities(option.value);
                            this.area = option.label;
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
                            this.city = option.label;
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
                        
                        // Update Vue data
                        this.warehouse = option.label;
                        this.selectedWarehouseLabel = option.label;
                    },

                    fixDropdownZIndex() {
                        // Use MutationObserver to watch for dropdown menu changes
                        const observer = new MutationObserver((mutations) => {
                            mutations.forEach((mutation) => {
                                if (mutation.type === 'childList') {
                                    mutation.addedNodes.forEach((node) => {
                                        if (node.nodeType === Node.ELEMENT_NODE) {
                                            const dropdown = node.querySelector ? node.querySelector('.vs__dropdown-menu') : null;
                                            if (dropdown) {
                                                dropdown.style.position = 'absolute';
                                                dropdown.style.zIndex = '9999';
                                                
                                                // Prevent dropdown from closing on mouse leave
                                                dropdown.addEventListener('mouseenter', (e) => {
                                                    e.stopPropagation();
                                                });
                                                
                                                dropdown.addEventListener('mouseleave', (e) => {
                                                    e.stopPropagation();
                                                });
                                            }
                                        }
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
                            document.querySelectorAll('.vs__dropdown-menu').forEach(dropdown => {
                                dropdown.style.position = 'absolute';
                                dropdown.style.zIndex = '9999';
                                
                                dropdown.addEventListener('mouseenter', (e) => {
                                    e.stopPropagation();
                                });
                                
                                dropdown.addEventListener('mouseleave', (e) => {
                                    e.stopPropagation();
                                });
                            });
                        }, 100);
                    },

                },
            });
        </script>
    @endpush

</x-shop::layouts.account>
