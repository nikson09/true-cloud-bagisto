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

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-checkout-address-form-template"
    >
        <div class="mt-2 max-md:mt-3">
            <x-shop::form.control-group class="hidden">
                <x-shop::form.control-group.control
                    type="text"
                    ::name="controlName + '.id'"
                    ::value="safeAddress.id"
                />
            </x-shop::form.control-group>


            <!-- First Name -->
            <div class="grid grid-cols-2 gap-x-5 max-md:grid-cols-1">
                <x-shop::form.control-group>
                    <x-shop::form.control-group.label class="required !mt-0">
                        @lang('shop::app.checkout.onepage.address.first-name')
                    </x-shop::form.control-group.label>

                    <x-shop::form.control-group.control
                        type="text"
                        ::name="controlName + '.first_name'"
                        ::value="safeAddress.first_name"
                        rules="required"
                        :label="trans('shop::app.checkout.onepage.address.first-name')"
                        :placeholder="trans('shop::app.checkout.onepage.address.first-name')"
                    />

                    <x-shop::form.control-group.error ::name="controlName + '.first_name'" />
                </x-shop::form.control-group>

                {!! view_render_event('bagisto.shop.checkout.onepage.address.form.first_name.after') !!}

                <!-- Last Name -->
                <x-shop::form.control-group>
                    <x-shop::form.control-group.label class="required !mt-0">
                        @lang('shop::app.checkout.onepage.address.last-name')
                    </x-shop::form.control-group.label>

                    <x-shop::form.control-group.control
                        type="text"
                        ::name="controlName + '.last_name'"
                        ::value="safeAddress.last_name"
                        rules="required"
                        :label="trans('shop::app.checkout.onepage.address.last-name')"
                        :placeholder="trans('shop::app.checkout.onepage.address.last-name')"
                    />

                    <x-shop::form.control-group.error ::name="controlName + '.last_name'" />
                </x-shop::form.control-group>

                {!! view_render_event('bagisto.shop.checkout.onepage.address.form.last_name.after') !!}
            </div>

            <!-- Email -->
            <x-shop::form.control-group>
                <x-shop::form.control-group.label class="required !mt-0">
                    @lang('shop::app.checkout.onepage.address.email')
                </x-shop::form.control-group.label>

                <x-shop::form.control-group.control
                    type="email"
                    ::name="controlName + '.email'"
                    ::value="safeAddress.email"
                    rules="required|email"
                    :label="trans('shop::app.checkout.onepage.address.email')"
                    placeholder="email@example.com"
                />

                <x-shop::form.control-group.error ::name="controlName + '.email'" />
            </x-shop::form.control-group>

            {!! view_render_event('bagisto.shop.checkout.onepage.address.form.email.after') !!}


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

                <x-shop::form.control-group.error ::name="controlName + '.area'" />
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

                <x-shop::form.control-group.error ::name="controlName + '.city'" />
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

                <x-shop::form.control-group.error ::name="controlName + '.warehouse'" />
            </x-shop::form.control-group>


            <!-- Hidden fields for compatibility -->
            <x-shop::form.control-group class="hidden">
                <x-shop::form.control-group.control
                    type="text"
                    ::name="controlName + '.address.[0]'"
                    ::value="safeAddress.address[0]"
                />
            </x-shop::form.control-group>

            {!! view_render_event('bagisto.shop.checkout.onepage.address.form.address.after') !!}

            <!-- Hidden fields for Ukraine -->
            <x-shop::form.control-group class="hidden">
                <x-shop::form.control-group.control
                    type="text"
                    ::name="controlName + '.country'"
                    value="UA"
                />
                <x-shop::form.control-group.control
                    type="text"
                    ::name="controlName + '.state'"
                    ::value="area"
                    v-model="area"
                />
                <x-shop::form.control-group.control
                    type="text"
                    ::name="controlName + '.city'"
                    ::value="city"
                    v-model="city"
                />
                <x-shop::form.control-group.control
                    type="text"
                    ::name="controlName + '.area'"
                    ::value="area"
                    v-model="area"
                />
                <x-shop::form.control-group.control
                    type="text"
                    ::name="controlName + '.warehouse'"
                    ::value="warehouse"
                    v-model="warehouse"
                />
            </x-shop::form.control-group>

            <!-- Postcode (optional for Nova Poshta) -->
            <x-shop::form.control-group>
                <x-shop::form.control-group.label class="!mt-0">
                    @lang('shop::app.checkout.onepage.address.postcode')
                </x-shop::form.control-group.label>

                <x-shop::form.control-group.control
                    type="text"
                    ::name="controlName + '.postcode'"
                    ::value="safeAddress.postcode"
                    rules="postcode"
                    :label="trans('shop::app.checkout.onepage.address.postcode')"
                    :placeholder="trans('shop::app.checkout.onepage.address.postcode')"
                />

                <x-shop::form.control-group.error ::name="controlName + '.postcode'" />
            </x-shop::form.control-group>

            {!! view_render_event('bagisto.shop.checkout.onepage.address.form.postcode.after') !!}

            <!-- Phone Number -->
            <x-shop::form.control-group>
                <x-shop::form.control-group.label class="required !mt-0">
                    @lang('shop::app.checkout.onepage.address.telephone')
                </x-shop::form.control-group.label>

                <x-shop::form.control-group.control
                    type="text"
                    ::name="controlName + '.phone'"
                    ::value="safeAddress.phone"
                    rules="required|phone"
                    :label="trans('shop::app.checkout.onepage.address.telephone')"
                    :placeholder="trans('shop::app.checkout.onepage.address.telephone')"
                />

                <x-shop::form.control-group.error ::name="controlName + '.phone'" />
            </x-shop::form.control-group>

            {!! view_render_event('bagisto.shop.checkout.onepage.address.form.phone.after') !!}
        </div>
    </script>

    <script type="module">
        app.component('v-checkout-address-form', {
            template: '#v-checkout-address-form-template',

            props: {
                controlName: {
                    type: String,
                    required: true,
                },

                address: {
                    type: Object,

                    default: () => ({
                        id: 0,
                        company_name: '',
                        first_name: '',
                        last_name: '',
                        email: '',
                        address: [],
                        country: 'UA',
                        state: '',
                        area: 'test',
                        city: '',
                        warehouse: '',
                        postcode: '',
                        phone: '',
                    }),
                },
            },

            computed: {
                safeAddress() {
                    return this.address || {
                        id: 0,
                        company_name: '',
                        first_name: '',
                        last_name: '',
                        email: '',
                        address: [],
                        country: 'UA',
                        state: '',
                        area: '',
                        city: '',
                        warehouse: '',
                        postcode: '',
                        phone: '',
                    };
                }
            },

            data() {
                return {
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
                }
            },

            mounted() {
                // Initialize Nova Poshta form
                this.initNovaPoshtaForm();
                this.fixDropdownZIndex();
            },

            methods: {
                initNovaPoshtaForm() {
                    this.loadAreas();
                },


                populateSelect(selectId, data) {
                    const select = document.getElementById(selectId);
                    if (!select) return;
                    
                    // Store the first option (placeholder)
                    const firstOption = select.children[0];
                    
                    // Clear all options
                    select.innerHTML = '';
                    
                    // Add back the first option
                    select.appendChild(firstOption);
                    
                    // Add new options immediately (no delay to prevent cursor issues)
                    data.forEach((item) => {
                        const option = document.createElement('option');
                        option.value = item.ref;
                        option.textContent = item.description_ru || item.description;
                        option.className = 'nova-poshta-option';
                        select.appendChild(option);
                    });
                    
                    // Add success state briefly
                    select.classList.add('success');
                    setTimeout(() => {
                        select.classList.remove('success');
                    }, 800);
                },

                clearSelect(selectId) {
                    const select = document.getElementById(selectId);
                    if (!select) return;
                    
                    // Clear existing options except the first one
                    while (select.children.length > 1) {
                        select.removeChild(select.lastChild);
                    }
                    select.value = '';
                },

                updateHiddenField(fieldName, value) {
                    // Try different selectors to find the hidden field
                    let hiddenField = document.querySelector(`input[name="${this.controlName}.${fieldName}"]`);
                    
                    if (!hiddenField) {
                        // Try with array notation
                        hiddenField = document.querySelector(`input[name="${this.controlName}[${fieldName}]"]`);
                    }
                    
                    if (!hiddenField) {
                        // Try with dot notation escaped
                        hiddenField = document.querySelector(`input[name="${this.controlName}\\.${fieldName}"]`);
                    }
                    
                    if (!hiddenField) {
                        // Try to find by partial name match
                        const allInputs = document.querySelectorAll('input');
                        for (let input of allInputs) {
                            if (input.name && input.name.includes(fieldName)) {
                                hiddenField = input;
                                break;
                            }
                        }
                    }
                    
                    if (hiddenField) {
                        hiddenField.value = value;
                        console.log(`Updated hidden field ${fieldName}:`, value, 'Field name:', hiddenField.name);
                    } else {
                        console.warn(`Hidden field ${fieldName} not found for controlName: ${this.controlName}`);
                        // Debug: log all input fields to see what's available
                        const allInputs = document.querySelectorAll('input');
                        console.log('Available input fields:', Array.from(allInputs).map(input => input.name));
                        
                        // Try to create the field if it doesn't exist
                        this.createHiddenField(fieldName, value);
                    }
                },

                createHiddenField(fieldName, value) {
                    // Create a hidden input field if it doesn't exist
                    const hiddenField = document.createElement('input');
                    hiddenField.type = 'hidden';
                    hiddenField.name = `${this.controlName}.${fieldName}`;
                    hiddenField.value = value;
                    
                    // Find the form and append the field
                    const form = document.querySelector('form');
                    if (form) {
                        form.appendChild(hiddenField);
                        console.log(`Created hidden field ${fieldName}:`, value);
                    }
                },


                // Method to force update all Nova Poshta fields from select values
                forceUpdateNovaPoshtaFields() {
                    const areaSelect = document.getElementById('nova-poshta-area');
                    const citySelect = document.getElementById('nova-poshta-city');
                    const warehouseSelect = document.getElementById('nova-poshta-warehouse');
                    
                    // Force update all fields
                    if (areaSelect) {
                        const areaValue = areaSelect.value || '';
                        this.safeAddress.area = areaValue;
                        this.updateHiddenField('area', areaValue);
                    }
                    
                    if (citySelect) {
                        const cityValue = citySelect.value || '';
                        this.safeAddress.city = cityValue;
                        this.updateHiddenField('city', cityValue);
                    }
                    
                    if (warehouseSelect) {
                        const warehouseValue = warehouseSelect.value || '';
                        this.safeAddress.warehouse = warehouseValue;
                        this.updateHiddenField('warehouse', warehouseValue);
                    }
                    
                    console.log('Force updated Nova Poshta fields:', {
                        area: this.safeAddress.area,
                        city: this.safeAddress.city,
                        warehouse: this.safeAddress.warehouse
                    });
                },

                // Method to debug form data before submission
                debugFormData() {
                    const form = document.querySelector('form');
                    if (form) {
                        const formData = new FormData(form);
                        console.log('Form data before submission:');
                        for (let [key, value] of formData.entries()) {
                            console.log(`${key}: ${value}`);
                        }
                    }
                    
                    // Also log all input fields
                    const allInputs = document.querySelectorAll('input');
                    console.log('All input fields:');
                    allInputs.forEach(input => {
                        if (input.name) {
                            console.log(`${input.name}: ${input.value}`);
                        }
                    });
                },

                // Method to ensure Nova Poshta fields are properly updated
                ensureNovaPoshtaFields() {
                    const areaSelect = document.getElementById('nova-poshta-area');
                    const citySelect = document.getElementById('nova-poshta-city');
                    const warehouseSelect = document.getElementById('nova-poshta-warehouse');
                    
                    if (areaSelect && areaSelect.value) {
                        this.updateHiddenField('area', areaSelect.value);
                        this.safeAddress.area = areaSelect.value;
                        this.safeAddress.state = areaSelect.selectedOptions[0]?.text || areaSelect.value;
                    }
                    
                    if (citySelect && citySelect.value) {
                        this.updateHiddenField('city', citySelect.value);
                        this.safeAddress.city = citySelect.value;
                    }
                    
                    if (warehouseSelect && warehouseSelect.value) {
                        this.updateHiddenField('warehouse', warehouseSelect.value);
                        this.safeAddress.warehouse = warehouseSelect.value;
                    }
                },

                // Show loading indicator
                showLoading(loadingId) {
                    const loadingElement = document.getElementById(loadingId);
                    if (loadingElement) {
                        loadingElement.classList.remove('hidden');
                    }
                },

                // Hide loading indicator
                hideLoading(loadingId) {
                    const loadingElement = document.getElementById(loadingId);
                    if (loadingElement) {
                        loadingElement.classList.add('hidden');
                    }
                },

                // Reset dependent selects when parent changes
                resetDependentSelects(selectId, placeholder) {
                    const select = document.getElementById(selectId);
                    if (select) {
                        select.innerHTML = `<option value="">${placeholder}</option>`;
                        select.value = '';
                        select.disabled = true;
                        select.className = select.className.replace('bg-white text-gray-700 cursor-pointer', 'bg-gray-50 text-gray-500 cursor-not-allowed');
                        
                        // Remove any state classes
                        select.classList.remove('success', 'error');
                    }
                },

                // Nova Poshta methods
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
                    this.selectedCity = null;
                    this.selectedWarehouse = null;
                    this.cityOptions = [];
                    this.warehouseOptions = [];
                    if (option.value) {
                        console.log('Loading cities for area:', option.value);
                        this.loadCities(option.value);
                        this.safeAddress.area = option.label;
                        this.safeAddress.state = option.label;
                        this.area = option.label;
                        this.state = option.label;
                    } else {
                        console.log('No area selected, not loading cities');
                    }
                },

                loadCities(areaRef) {
                    this.cityLoading = true;
                    
                    fetch(`{{ route('api.nova-poshta.cities') }}?area_ref=${areaRef}`)
                        .then(response => response.json())
                        .then(data => {
                            console.log('Cities response:', data);
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
                        this.safeAddress.city = option.label;
                        this.city = option.label;
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
                    this.safeAddress.warehouse = option.label;
                    
                    // Update hidden field  
                    this.warehouse = option.label;
                },

                fixDropdownZIndex() {
                    this.$nextTick(() => {
                        const observer = new MutationObserver((mutations) => {
                            mutations.forEach((mutation) => {
                                if (mutation.type === 'childList') {
                                    const dropdowns = document.querySelectorAll('.vs__dropdown-menu');
                                    dropdowns.forEach((dropdown) => {
                                        dropdown.style.zIndex = '9999';
                                        dropdown.style.position = 'absolute';
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
                        observer.observe(document.body, {
                            childList: true,
                            subtree: true
                        });
                        setTimeout(() => {
                            const dropdowns = document.querySelectorAll('.vs__dropdown-menu');
                            dropdowns.forEach((dropdown) => {
                                dropdown.style.zIndex = '9999';
                                dropdown.style.position = 'absolute';
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
@endPushOnce
