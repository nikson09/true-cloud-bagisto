<v-create-customer-address @address-created="addressCreated">
    <div class="mr-1 inline-flex w-full max-w-max cursor-pointer items-center justify-between gap-x-2 px-1 py-1.5 text-center font-semibold text-gray-600 transition-all hover:rounded-md hover:bg-gray-200 dark:text-gray-300 dark:hover:bg-gray-800">
        <span class="icon-location text-2xl"></span>

        @lang('admin::app.customers.customers.view.address.create.create-address-btn')
    </div>
</v-create-customer-address>

<!-- Customer Address Modal -->
@pushOnce('scripts')
    <!-- Customer Address Form -->
    <script
        type="text/x-template"
        id="v-create-customer-address-template"
    >
        <!-- Address Create Button -->
        @if (bouncer()->hasPermission('customers.addresses.create'))
            <div
                class="flex cursor-pointer items-center justify-between gap-1.5 px-2.5 text-blue-600 transition-all hover:underline"
                @click="$refs.createAddress.toggle()"
            >
                @lang('admin::app.customers.customers.view.address.create.create-btn')
            </div>
        @endif

        {!! view_render_event('bagisto.admin.customers.addresses.create.before') !!}

        <x-admin::form
            v-slot="{ meta, errors, handleSubmit }"
            as="div"
        >
            <form @submit="handleSubmit($event, create)">
                {!! view_render_event('bagisto.admin.customers.addresses.create.create_form_controls.before') !!}

                <!-- Address Create Drawer -->
                <x-admin::drawer
                    width="350px"
                    ref="createAddress"
                >
                    <!-- Drawer Header -->
                    <x-slot:header class="py-5">
                        <p class="text-lg font-bold text-gray-800 dark:text-white">
                            @lang('admin::app.customers.customers.view.address.create.title')
                        </p>
                    </x-slot>

                    <!-- Drawer Content -->
                    <x-slot:content>
                        {!! view_render_event('bagisto.admin.customers.addresses.create.before') !!}

                        <!-- Company Name -->
                        <x-admin::form.control-group class="w-full">
                            <x-admin::form.control-group.label>
                                @lang('admin::app.customers.customers.view.address.create.company-name')
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="hidden"
                                name="customer_id"
                                :value="$customer->id"
                            />

                            <x-admin::form.control-group.control
                                type="text"
                                name="company_name"
                                :label="trans('admin::app.customers.customers.view.address.create.company-name')"
                                :placeholder="trans('admin::app.customers.customers.view.address.create.company-name')"
                            />

                            <x-admin::form.control-group.error control-name="company_name" />
                        </x-admin::form.control-group>

                        <!-- Vat Id -->
                        <x-admin::form.control-group class="w-full">
                            <x-admin::form.control-group.label>
                                @lang('admin::app.customers.customers.view.address.create.vat-id')
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="text"
                                name="vat_id"
                                :label="trans('admin::app.customers.customers.view.address.create.vat-id')"
                                :placeholder="trans('admin::app.customers.customers.view.address.create.vat-id')"
                            />

                            <x-admin::form.control-group.error control-name="vat_id" />
                        </x-admin::form.control-group>

                        <!-- First Name -->
                        <x-admin::form.control-group class="w-full">
                            <x-admin::form.control-group.label class="required">
                                @lang('admin::app.customers.customers.view.address.create.first-name')
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="text"
                                name="first_name"
                                rules="required"
                                :label="trans('admin::app.customers.customers.view.address.create.first-name')"
                                :placeholder="trans('admin::app.customers.customers.view.address.create.first-name')"
                            />

                            <x-admin::form.control-group.error control-name="first_name" />
                        </x-admin::form.control-group>

                        <!-- Last Name -->
                        <x-admin::form.control-group class="w-full">
                            <x-admin::form.control-group.label class="required">
                                @lang('admin::app.customers.customers.view.address.create.last-name')
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="text"
                                name="last_name"
                                rules="required"
                                :label="trans('admin::app.customers.customers.view.address.create.last-name')"
                                :placeholder="trans('admin::app.customers.customers.view.address.create.last-name')"
                            />

                            <x-admin::form.control-group.error control-name="last_name" />
                        </x-admin::form.control-group>

                        <!-- E-mail -->
                        <x-admin::form.control-group class="w-full">
                            <x-admin::form.control-group.label class="required">
                                @lang('admin::app.customers.customers.view.address.create.email')
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="text"
                                name="email"
                                rules="required|email"
                                :label="trans('admin::app.customers.customers.view.address.create.email')"
                                :placeholder="trans('admin::app.customers.customers.view.address.create.email')"
                            />

                            <x-admin::form.control-group.error control-name="email" />
                        </x-admin::form.control-group>

                        <!-- Nova Poshta Area Selection -->
                        <x-admin::form.control-group class="w-full">
                            <x-admin::form.control-group.label class="required">
                                Область
                            </x-admin::form.control-group.label>

                            <select 
                                name="area"
                                id="nova-poshta-area-admin-create"
                                class="flex w-full min-h-[39px] py-2 px-3 border border-gray-300 rounded-md text-sm text-gray-600 transition-all hover:border-gray-400 focus:border-gray-400 focus:ring-gray-100"
                            >
                                <option value="">Виберіть область</option>
                            </select>

                            <x-admin::form.control-group.error control-name="area" />
                        </x-admin::form.control-group>

                        <!-- Nova Poshta City Selection -->
                        <x-admin::form.control-group class="w-full">
                            <x-admin::form.control-group.label class="required">
                                Місто
                            </x-admin::form.control-group.label>

                            <select 
                                name="city"
                                id="nova-poshta-city-admin-create"
                                disabled
                                class="flex w-full min-h-[39px] py-2 px-3 border border-gray-300 rounded-md text-sm text-gray-600 transition-all hover:border-gray-400 focus:border-gray-400 focus:ring-gray-100"
                            >
                                <option value="">Виберіть місто</option>
                            </select>

                            <x-admin::form.control-group.error control-name="city" />
                        </x-admin::form.control-group>

                        <!-- Nova Poshta Warehouse Selection -->
                        <x-admin::form.control-group class="w-full">
                            <x-admin::form.control-group.label class="required">
                                Відділення Нової Пошти
                            </x-admin::form.control-group.label>

                            <select 
                                name="warehouse"
                                id="nova-poshta-warehouse-admin-create"
                                disabled
                                class="flex w-full min-h-[39px] py-2 px-3 border border-gray-300 rounded-md text-sm text-gray-600 transition-all hover:border-gray-400 focus:border-gray-400 focus:ring-gray-100"
                            >
                                <option value="">Виберіть відділення</option>
                            </select>

                            <x-admin::form.control-group.error control-name="warehouse" />
                        </x-admin::form.control-group>

                        <!-- Hidden fields for Ukraine -->
                        <x-admin::form.control-group class="hidden">
                            <x-admin::form.control-group.control
                                type="text"
                                name="country"
                                value="UA"
                            />
                            <x-admin::form.control-group.control
                                type="text"
                                name="state"
                                v-model="state"
                            />
                        </x-admin::form.control-group>

                        <!--Phone number -->
                        <x-admin::form.control-group class="w-full">
                            <x-admin::form.control-group.label class="required">
                                @lang('admin::app.customers.customers.view.address.create.phone')
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="text"
                                name="phone"
                                rules="required|phone"
                                :label="trans('admin::app.customers.customers.view.address.create.phone')"
                                :placeholder="trans('admin::app.customers.customers.view.address.create.phone')"
                            />

                            <x-admin::form.control-group.error control-name="phone" />
                        </x-admin::form.control-group>

                        <!-- Street Address -->
                        <x-admin::form.control-group>
                            <x-admin::form.control-group.label class="required">
                                @lang('admin::app.customers.customers.view.address.create.street-address')
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="text"
                                id="address[0]"
                                name="address[0]"
                                class="mb-2"
                                rules="required"
                                :label="trans('admin::app.customers.customers.view.address.create.street-address')"
                                :placeholder="trans('admin::app.customers.customers.view.address.create.street-address')"
                            />

                            <x-admin::form.control-group.error
                                class="mb-2"
                                control-name="address[0]"
                            />

                            <x-admin::form.control-group.error control-name="address[]" />

                            @if (core()->getConfigData('customer.address.information.street_lines') > 1)
                                @for ($i = 1; $i < core()->getConfigData('customer.address.information.street_lines'); $i++)
                                    <x-admin::form.control-group.control
                                        type="text"
                                        id="address[{{ $i }}]"
                                        name="address[{{ $i }}]"
                                        :label="trans('admin::app.customers.customers.view.address.create.street-address')"
                                        :placeholder="trans('admin::app.customers.customers.view.address.create.street-address')"
                                    />

                                    <x-admin::form.control-group.error control-name="address[{{ $i }}]" />
                                @endfor
                            @endif
                        </x-admin::form.control-group>

                        <!-- City -->
                        <x-admin::form.control-group class="w-full">
                            <x-admin::form.control-group.label class="required">
                                @lang('admin::app.customers.customers.view.address.create.city')
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="text"
                                name="city"
                                rules="required"
                                :label="trans('admin::app.customers.customers.view.address.create.city')"
                                :placeholder="trans('admin::app.customers.customers.view.address.create.city')"
                            />

                            <x-admin::form.control-group.error control-name="city" />
                        </x-admin::form.control-group>

                        <!-- PostCode -->
                        <x-admin::form.control-group class="w-full">
                            <x-admin::form.control-group.label class="required">
                                @lang('admin::app.customers.customers.view.address.create.post-code')
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="text"
                                name="postcode"
                                rules="required|postcode"
                                :label="trans('admin::app.customers.customers.view.address.create.post-code')"
                                :placeholder="trans('admin::app.customers.customers.view.address.create.post-code')"
                            />

                            <x-admin::form.control-group.error control-name="postcode" />
                        </x-admin::form.control-group>

                        <!-- Country Name -->
                        <x-admin::form.control-group class="w-full">
                            <x-admin::form.control-group.label class="required">
                                @lang('admin::app.customers.customers.view.address.create.country')
                            </x-admin::form.control-group.label>

                            <x-admin::form.control-group.control
                                type="select"
                                name="country"
                                rules="required"
                                v-model="country"
                                :label="trans('admin::app.customers.customers.view.address.create.country')"
                            >
                                @foreach (core()->countries() as $country)
                                    <option value="{{ $country->code }}">{{ $country->name }}</option>
                                @endforeach
                            </x-admin::form.control-group.control>

                            <x-admin::form.control-group.error control-name="country" />
                        </x-admin::form.control-group>

                        <!-- State Name -->
                        <x-admin::form.control-group class="w-full">
                            <x-admin::form.control-group.label class="required">
                                @lang('admin::app.customers.customers.view.address.create.state')
                            </x-admin::form.control-group.label>

                            <template v-if="haveStates()">
                                <x-admin::form.control-group.control
                                    type="select"
                                    id="state"
                                    name="state"
                                    rules="required"
                                    v-model="state"
                                    :label="trans('admin::app.customers.customers.view.address.create.state')"
                                    :placeholder="trans('admin::app.customers.customers.view.address.create.state')"
                                >
                                    <option
                                        v-for='(state, index) in countryStates[country]'
                                        :value="state.code"
                                    >
                                        @{{ state.default_name }}
                                    </option>
                                </x-admin::form.control-group.control>
                            </template>

                            <template v-else>
                                <x-admin::form.control-group.control
                                    type="text"
                                    name="state"
                                    rules="required"
                                    :label="trans('admin::app.customers.customers.view.address.create.state')"
                                    :placeholder="trans('admin::app.customers.customers.view.address.create.state')"
                                />
                            </template>

                            <x-admin::form.control-group.error control-name="state" />
                        </x-admin::form.control-group>

                        <!-- Default Address -->
                        <x-admin::form.control-group class="flex items-center gap-2.5">
                            <x-admin::form.control-group.control
                                type="checkbox"
                                id="default_address"
                                name="default_address"
                                :value="1"
                                for="default_address"
                                :label="trans('admin::app.customers.customers.view.address.create.default-address')"
                                :checked="false"
                            />

                            <label
                                class="cursor-pointer text-xs font-medium text-gray-600 dark:text-gray-300"
                                for="default_address"
                            >
                                @lang('admin::app.customers.customers.view.address.create.default-address')
                            </label>
                        </x-admin::form.control-group>

                        <x-admin::form.control-group.error control-name="default_address" />

                        {!! view_render_event('bagisto.admin.customers.create.after') !!}

                        <!-- Modal Submission -->
                        <x-admin::button
                            button-type="submit"
                            class="primary-button w-full max-w-full justify-center"
                            :title="trans('admin::app.customers.customers.view.address.create.save-btn-title')"
                            ::loading="isLoading"
                            ::disabled="isLoading"
                        />
                    </x-slot>
                </x-admin::drawer>

                {!! view_render_event('bagisto.admin.customers.addresses.create.create_form_controls.after') !!}

            </form>
        </x-admin::form>

        {!! view_render_event('bagisto.admin.customers.addresses.create.after') !!}

    </script>

    <script type="module">
        app.component('v-create-customer-address', {
            template: '#v-create-customer-address-template',

            emits: ['address-created'],

            data() {
                return {
                    country: "",
                    state: "",
                    countryStates: {!! json_encode(core()->groupedStatesByCountries()) !!},
                    isLoading: false,
                };
            },

            mounted() {
                // Initialize Nova Poshta form for admin create
                this.initNovaPoshtaForm();
            },

            methods: {
                create(params, { resetForm, setErrors }) {
                    this.isLoading = true;

                    params.default_address = params.default_address ?? 0;

                    this.$axios.post('{{ route('admin.customers.customers.addresses.store', $customer->id) }}', params)
                        .then((response) => {
                            this.$emitter.emit('add-flash', { type: 'success', message: response.data.message });

                            this.$emit('address-created', response.data.data);

                            resetForm();

                            this.isLoading = false;

                            this.$refs.createAddress.toggle();
                        })
                        .catch(error => {
                            this.isLoading = false;

                            if (error.response.status == 422) {
                                setErrors(error.response.data.errors);
                            }
                        });
                },

                haveStates() {
                    /*
                    * The double negation operator is used to convert the value to a boolean.
                    * It ensures that the final result is a boolean value,
                    * true if the array has a length greater than 0, and otherwise false.
                    */
                    return !!this.countryStates[this.country]?.length;
                },

                initNovaPoshtaForm() {
                    // Wait for DOM to be ready
                    this.$nextTick(() => {
                        const areaSelect = document.getElementById('nova-poshta-area-admin-create');
                        const citySelect = document.getElementById('nova-poshta-city-admin-create');
                        const warehouseSelect = document.getElementById('nova-poshta-warehouse-admin-create');
                        
                        if (areaSelect && citySelect && warehouseSelect) {
                            // Load areas
                            this.loadAreas();
                            
                            // Add event listeners
                            areaSelect.addEventListener('change', (e) => {
                                this.onAreaChange(e.target.value);
                            });
                            
                            citySelect.addEventListener('change', (e) => {
                                this.onCityChange(e.target.value);
                            });
                            
                            warehouseSelect.addEventListener('change', (e) => {
                                this.onWarehouseChange(e.target.value);
                            });
                        }
                    });
                },

                loadAreas() {
                    fetch("{{ route('api.nova-poshta.areas') }}")
                        .then(response => response.json())
                        .then(data => {
                            console.log('Areas response:', data);
                            if (data.success) {
                                this.populateSelect('nova-poshta-area-admin-create', data.data);
                            }
                        })
                        .catch(error => {
                            console.error('Error loading areas:', error);
                        });
                },

                onAreaChange(areaRef) {
                    console.log('Area changed to:', areaRef);
                    
                    // Clear city and warehouse
                    this.clearSelect('nova-poshta-city-admin-create');
                    this.clearSelect('nova-poshta-warehouse-admin-create');
                    document.getElementById('nova-poshta-city-admin-create').disabled = true;
                    document.getElementById('nova-poshta-warehouse-admin-create').disabled = true;
                    
                    if (areaRef) {
                        this.loadCities(areaRef);
                    }
                },

                loadCities(areaRef) {
                    fetch(`{{ route('api.nova-poshta.cities') }}?area_ref=${areaRef}`)
                        .then(response => response.json())
                        .then(data => {
                            console.log('Cities response:', data);
                            if (data.success) {
                                this.populateSelect('nova-poshta-city-admin-create', data.data);
                                document.getElementById('nova-poshta-city-admin-create').disabled = false;
                            }
                        })
                        .catch(error => {
                            console.error('Error loading cities:', error);
                        });
                },

                onCityChange(cityRef) {
                    console.log('City changed to:', cityRef);
                    
                    // Clear warehouse
                    this.clearSelect('nova-poshta-warehouse-admin-create');
                    document.getElementById('nova-poshta-warehouse-admin-create').disabled = true;
                    
                    if (cityRef) {
                        this.loadWarehouses(cityRef);
                    }
                },

                loadWarehouses(cityRef) {
                    fetch(`{{ route('api.nova-poshta.warehouses') }}?city_ref=${cityRef}`)
                        .then(response => response.json())
                        .then(data => {
                            console.log('Warehouses response:', data);
                            if (data.success) {
                                this.populateSelect('nova-poshta-warehouse-admin-create', data.data);
                                document.getElementById('nova-poshta-warehouse-admin-create').disabled = false;
                            }
                        })
                        .catch(error => {
                            console.error('Error loading warehouses:', error);
                        });
                },

                onWarehouseChange(warehouseRef) {
                    console.log('Warehouse changed to:', warehouseRef);
                },

                populateSelect(selectId, data) {
                    const select = document.getElementById(selectId);
                    if (!select) return;
                    
                    // Clear existing options except the first one
                    while (select.children.length > 1) {
                        select.removeChild(select.lastChild);
                    }
                    
                    // Add new options
                    data.forEach(item => {
                        const option = document.createElement('option');
                        option.value = item.ref;
                        option.textContent = item.description_ru || item.description;
                        select.appendChild(option);
                    });
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
            },
        });
    </script>
@endPushOnce
