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
                    ::value="address.id"
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
                        ::value="address.first_name"
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
                        ::value="address.last_name"
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
                    ::value="address.email"
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

                <div class="relative">
                    <select 
                        :name="controlName + '.area'"
                        id="nova-poshta-area"
                        rules="required"
                        :label="'Область'"
                        class="nova-poshta-select flex w-full min-h-[48px] py-3 px-4 border border-gray-300 rounded-lg text-sm text-gray-700 bg-white transition-all duration-200 hover:border-blue-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 focus:outline-none appearance-none cursor-pointer shadow-sm"
                    >
                        <option value="">Виберіть область</option>
                    </select>
                    
                    <!-- Custom dropdown arrow -->
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                    
                    <!-- Loading indicator for area -->
                    <div id="area-loading" class="absolute inset-y-0 right-8 flex items-center hidden">
                        <svg class="animate-spin w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                </div>

                <x-shop::form.control-group.error ::name="controlName + '.area'" />
            </x-shop::form.control-group>

            <!-- Nova Poshta City Selection -->
            <x-shop::form.control-group>
                <x-shop::form.control-group.label class="required !mt-0">
                    Місто
                </x-shop::form.control-group.label>

                <div class="relative">
                    <select 
                        :name="controlName + '.city'"
                        id="nova-poshta-city"
                        disabled
                        rules="required"
                        :label="'Місто'"
                        class="nova-poshta-select flex w-full min-h-[48px] py-3 px-4 border border-gray-300 rounded-lg text-sm text-gray-500 bg-gray-50 transition-all duration-200 hover:border-blue-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 focus:outline-none appearance-none cursor-not-allowed shadow-sm disabled:opacity-60"
                    >
                        <option value="">Спочатку виберіть область</option>
                    </select>
                    
                    <!-- Custom dropdown arrow -->
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                    
                    <!-- Loading indicator for city -->
                    <div id="city-loading" class="absolute inset-y-0 right-8 flex items-center hidden">
                        <svg class="animate-spin w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                </div>

                <x-shop::form.control-group.error ::name="controlName + '.city'" />
            </x-shop::form.control-group>

            <!-- Nova Poshta Warehouse Selection -->
            <x-shop::form.control-group>
                <x-shop::form.control-group.label class="required !mt-0">
                    Відділення Нової Пошти
                </x-shop::form.control-group.label>

                <div class="relative">
                    <select 
                        :name="controlName + '.warehouse'"
                        id="nova-poshta-warehouse"
                        disabled
                        rules="required"
                        :label="'Відділення Нової Пошти'"
                        class="nova-poshta-select flex w-full min-h-[48px] py-3 px-4 border border-gray-300 rounded-lg text-sm text-gray-500 bg-gray-50 transition-all duration-200 hover:border-blue-400 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 focus:outline-none appearance-none cursor-not-allowed shadow-sm disabled:opacity-60"
                    >
                        <option value="">Спочатку виберіть місто</option>
                    </select>
                    
                    <!-- Custom dropdown arrow -->
                    <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                        </svg>
                    </div>
                    
                    <!-- Loading indicator for warehouse -->
                    <div id="warehouse-loading" class="absolute inset-y-0 right-8 flex items-center hidden">
                        <svg class="animate-spin w-4 h-4 text-blue-500" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                </div>

                <x-shop::form.control-group.error ::name="controlName + '.warehouse'" />
            </x-shop::form.control-group>


            <!-- Hidden fields for compatibility -->
            <x-shop::form.control-group class="hidden">
                <x-shop::form.control-group.control
                    type="text"
                    ::name="controlName + '.address.[0]'"
                    ::value="address.address[0]"
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
                    v-model="address.state"
                />
                <x-shop::form.control-group.control
                    type="text"
                    ::name="controlName + '.city'"
                    v-model="address.city"
                />
                <x-shop::form.control-group.control
                    type="text"
                    ::name="controlName + '.area'"
                    v-model="address.area"
                />
                <x-shop::form.control-group.control
                    type="text"
                    ::name="controlName + '.warehouse'"
                    v-model="address.warehouse"
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
                    ::value="address.postcode"
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
                    ::value="address.phone"
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
                        area: '',
                        city: '',
                        warehouse: '',
                        postcode: '',
                        phone: '',
                    }),
                },
            },
            mounted() {
                // Initialize Nova Poshta form
                this.initNovaPoshtaForm();
            },

            methods: {
                initNovaPoshtaForm() {
                    // Wait for DOM to be ready
                    this.$nextTick(() => {
                        const areaSelect = document.getElementById('nova-poshta-area');
                        const citySelect = document.getElementById('nova-poshta-city');
                        const warehouseSelect = document.getElementById('nova-poshta-warehouse');
                        
                        if (areaSelect && citySelect && warehouseSelect) {
                            // Initialize hidden fields
                            this.updateHiddenField('area', '');
                            this.updateHiddenField('city', '');
                            this.updateHiddenField('warehouse', '');
                            
                            // Load areas
                            this.loadAreas();
                            
                            // Add event listeners
                            areaSelect.addEventListener('change', (e) => {
                                this.address.state = document.querySelector(`select[name="${e.target.name}"]`).selectedOptions[0].label;
                                this.address.area = document.querySelector(`select[name="${e.target.name}"]`).selectedOptions[0].label;
                                this.onAreaChange(e.target.value);
                                this.ensureNovaPoshtaFields();
                            });
                            
                            citySelect.addEventListener('change', (e) => {
                                this.address.city = document.querySelector(`select[name="${e.target.name}"]`).selectedOptions[0].label;
                                this.onCityChange(e.target.value);
                                this.ensureNovaPoshtaFields();
                            });
                            
                            warehouseSelect.addEventListener('change', (e) => {
                                this.address.warehouse = document.querySelector(`select[name="${e.target.name}"]`).selectedOptions[0].label;
                                this.onWarehouseChange(e.target.value);
                                this.ensureNovaPoshtaFields();
                            });
                        }
                    });
                },

                loadAreas() {
                    this.showLoading('area-loading');
                    
                    fetch("{{ route('api.nova-poshta.areas') }}")
                        .then(response => response.json())
                        .then(data => {
                            console.log('Areas response:', data);
                            if (data.success) {
                                this.populateSelect('nova-poshta-area', data.data);
                            }
                        })
                        .catch(error => {
                            console.error('Error loading areas:', error);
                        })
                        .finally(() => {
                            this.hideLoading('area-loading');
                        });
                },

                onAreaChange(areaRef) {
                    console.log('Area changed to:', areaRef);
                    
                    // Update hidden field with multiple approaches
                    this.updateHiddenField('area', areaRef);
                    
                    // Also directly update any existing hidden field
                    const hiddenAreaField = document.querySelector(`input[name*="area"]`);
                    if (hiddenAreaField) {
                        hiddenAreaField.value = areaRef;
                        console.log('Directly updated area field:', hiddenAreaField.name, '=', areaRef);
                    }
                    
                    // Reset dependent selects
                    this.resetDependentSelects('nova-poshta-city', 'Спочатку виберіть область');
                    this.resetDependentSelects('nova-poshta-warehouse', 'Спочатку виберіть місто');
                    
                    if (areaRef) {
                        this.loadCities(areaRef);
                    }
                },

                loadCities(areaRef) {
                    this.showLoading('city-loading');
                    
                    // Update city select placeholder
                    const citySelect = document.getElementById('nova-poshta-city');
                    citySelect.innerHTML = '<option value="">Завантаження міст...</option>';
                    
                    fetch(`{{ route('api.nova-poshta.cities') }}?area_ref=${areaRef}`)
                        .then(response => response.json())
                        .then(data => {
                            console.log('Cities response:', data);
                            if (data.success) {
                                // Use requestAnimationFrame to ensure smooth DOM updates
                                requestAnimationFrame(() => {
                                    // Clear the loading text and populate with actual data
                                    citySelect.innerHTML = '<option value="">Виберіть місто</option>';
                                    this.populateSelect('nova-poshta-city', data.data);
                                    citySelect.disabled = false;
                                    citySelect.className = citySelect.className.replace('bg-gray-50 text-gray-500 cursor-not-allowed', 'bg-white text-gray-700 cursor-pointer');
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error loading cities:', error);
                            citySelect.innerHTML = '<option value="">Помилка завантаження міст</option>';
                        })
                        .finally(() => {
                            this.hideLoading('city-loading');
                        });
                },

                onCityChange(cityRef) {
                    console.log('City changed to:', cityRef);
                    
                    // Update hidden field with multiple approaches
                    this.updateHiddenField('city', cityRef);
                    
                    // Also directly update any existing hidden field
                    const hiddenCityField = document.querySelector(`input[name*="city"]`);
                    if (hiddenCityField) {
                        hiddenCityField.value = cityRef;
                        console.log('Directly updated city field:', hiddenCityField.name, '=', cityRef);
                    }
                    
                    // Reset dependent select
                    this.resetDependentSelects('nova-poshta-warehouse', 'Спочатку виберіть місто');
                    
                    if (cityRef) {
                        this.loadWarehouses(cityRef);
                    }
                },

                loadWarehouses(cityRef) {
                    this.showLoading('warehouse-loading');
                    
                    // Update warehouse select placeholder
                    const warehouseSelect = document.getElementById('nova-poshta-warehouse');
                    warehouseSelect.innerHTML = '<option value="">Завантаження відділень...</option>';
                    
                    fetch(`{{ route('api.nova-poshta.warehouses') }}?city_ref=${cityRef}`)
                        .then(response => response.json())
                        .then(data => {
                            console.log('Warehouses response:', data);
                            if (data.success) {
                                // Use requestAnimationFrame to ensure smooth DOM updates
                                requestAnimationFrame(() => {
                                    // Clear the loading text and populate with actual data
                                    warehouseSelect.innerHTML = '<option value="">Виберіть відділення</option>';
                                    this.populateSelect('nova-poshta-warehouse', data.data);
                                    warehouseSelect.disabled = false;
                                    warehouseSelect.className = warehouseSelect.className.replace('bg-gray-50 text-gray-500 cursor-not-allowed', 'bg-white text-gray-700 cursor-pointer');
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error loading warehouses:', error);
                            warehouseSelect.innerHTML = '<option value="">Помилка завантаження відділень</option>';
                        })
                        .finally(() => {
                            this.hideLoading('warehouse-loading');
                        });
                },

                onWarehouseChange(warehouseRef) {
                    console.log('Warehouse changed to:', warehouseRef);
                    
                    // Update Vue data
                    this.address.warehouse = warehouseRef;
                    
                    // Update hidden field with multiple approaches
                    this.updateHiddenField('warehouse', warehouseRef);
                    
                    // Also directly update any existing hidden field
                    const hiddenWarehouseField = document.querySelector(`input[name*="warehouse"]`);
                    if (hiddenWarehouseField) {
                        hiddenWarehouseField.value = warehouseRef;
                        console.log('Directly updated warehouse field:', hiddenWarehouseField.name, '=', warehouseRef);
                    }
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
                        this.address.area = areaValue;
                        this.updateHiddenField('area', areaValue);
                    }
                    
                    if (citySelect) {
                        const cityValue = citySelect.value || '';
                        this.address.city = cityValue;
                        this.updateHiddenField('city', cityValue);
                    }
                    
                    if (warehouseSelect) {
                        const warehouseValue = warehouseSelect.value || '';
                        this.address.warehouse = warehouseValue;
                        this.updateHiddenField('warehouse', warehouseValue);
                    }
                    
                    console.log('Force updated Nova Poshta fields:', {
                        area: this.address.area,
                        city: this.address.city,
                        warehouse: this.address.warehouse
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
                        this.address.area = areaSelect.value;
                        this.address.state = areaSelect.selectedOptions[0]?.text || areaSelect.value;
                    }
                    
                    if (citySelect && citySelect.value) {
                        this.updateHiddenField('city', citySelect.value);
                        this.address.city = citySelect.value;
                    }
                    
                    if (warehouseSelect && warehouseSelect.value) {
                        this.updateHiddenField('warehouse', warehouseSelect.value);
                        this.address.warehouse = warehouseSelect.value;
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
                }
            }
        });
    </script>
@endPushOnce
