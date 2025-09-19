{!! view_render_event('bagisto.shop.checkout.onepage.address.customer.before') !!}

<!-- Customer Address Vue Component -->
<v-checkout-address-customer
    :cart="cart"
    @processing="stepForward"
    @processed="stepProcessed"
>
    <!-- Billing Address Shimmer -->
    <x-shop::shimmer.checkout.onepage.address />
</v-checkout-address-customer>

{!! view_render_event('bagisto.shop.checkout.onepage.address.customer.after') !!}

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-checkout-address-customer-template"
    >
        <template v-if="isLoading">
            <!-- Billing Address Shimmer -->
            <x-shop::shimmer.checkout.onepage.address />
        </template>

        <template v-else>
            <!-- Saved Addresses -->
            <template v-if="! activeAddressForm && customerSavedAddresses.billing.length">
                <x-shop::form
                    v-slot="{ meta, errors, handleSubmit }"
                    as="div"
                >
                    <form @submit="handleSubmit($event, addAddressToCart)">
                        <!-- Billing Address Header -->
                        <div class="mb-4 flex items-center justify-between max-md:mb-2">
                            <h2 class="text-xl font-medium max-sm:text-base max-sm:font-normal">
                                @lang('shop::app.checkout.onepage.address.billing-address')
                            </h2>
                        </div>

                        <!-- Saved Customer Addresses Cards -->
                        <div class="mb-2 grid grid-cols-2 gap-5 max-1060:grid-cols-[1fr] max-lg:grid-cols-2 max-md:mt-2 max-md:grid-cols-1">
                            <div
                                class="relative max-w-[414px] cursor-pointer select-none rounded-xl border border-zinc-200 p-0 max-md:flex-wrap max-md:rounded-lg"
                                v-for="address in customerSavedAddresses.billing"
                            >
                                <!-- Actions -->
                                <div class="absolute top-5 flex gap-2 ltr:right-5 rtl:left-5">
                                    <x-shop::form.control-group class="!mb-0 flex items-center gap-2.5">
                                        <x-shop::form.control-group.control
                                            type="radio"
                                            name="billing.id"
                                            ::id="`billing_address_id_${address.id}`"
                                            ::for="`billing_address_id_${address.id}`"
                                            ::value="address.id"
                                            v-model="selectedAddresses.billing_address_id"
                                            rules="required"
                                            label="{{ trans('shop::app.checkout.onepage.address.billing-address') }}"
                                        />
                                    </x-shop::form.control-group>

                                    <!-- Edit Icon -->
                                    <span
                                        class="icon-edit cursor-pointer text-2xl"
                                        @click="
                                            selectedAddressForEdit = address;
                                            activeAddressForm = 'billing';
                                            saveAddress = address.address_type == 'customer'
                                        "
                                    ></span>
                                </div>

                                <!-- Details -->
                                <label
                                    class="block cursor-pointer rounded-xl p-5 max-sm:rounded-lg"
                                    :for="`billing_address_id_${address.id}`"
                                >
                                    <span class="icon-checkout-address text-6xl text-navyBlue max-sm:text-5xl"></span>

                                    <div class="flex items-center justify-between">
                                        <p class="text-base font-medium">
                                            @{{ address.first_name + ' ' + address.last_name }}

                                            <template v-if="address.company_name">
                                                (@{{ address.company_name }})
                                            </template>
                                        </p>
                                    </div>

                                    <p class="mt-6 text-sm text-zinc-500 max-md:mt-2 max-sm:mt-0">
                                        <template v-if="address.address">
                                            @{{ address.address.join(' ') }}<template v-if="address.warehouse"> @{{ address.warehouse }}</template>,
                                        </template>
                                        <template v-else-if="address.warehouse">
                                            @{{ address.warehouse }},
                                        </template>

                                        @{{ address.city }},
                                        @{{ address.state }}, @{{ address.country }},
                                        @{{ address.postcode }}
                                    </p>
                                </label>
                            </div>

                            <!-- New Address Card -->
                            <div
                                class="flex max-w-[414px] cursor-pointer items-center justify-center rounded-xl border border-zinc-200 p-5 max-md:flex-wrap max-md:rounded-lg"
                                @click="activeAddressForm = 'billing'"
                                v-if="! cart.billing_address"
                            >
                                <div
                                    class="flex items-center gap-x-2.5"
                                    role="button"
                                    tabindex="0"
                                >
                                    <span
                                        class="icon-plus rounded-full border border-black p-2.5 text-3xl max-sm:p-2"
                                        role="presentation"
                                    ></span>

                                    <p class="text-base">@lang('shop::app.checkout.onepage.address.add-new-address')</p>
                                </div>
                            </div>
                        </div>

                        <!-- Error Message Block -->
                        <x-shop::form.control-group.error name="billing.id" />

                        <!-- Shipping Address Block if have stockable items -->
                        <template v-if="cart.have_stockable_items">
                            <!-- Use for Shipping Checkbox -->
                            <x-shop::form.control-group class="!mb-0 mt-5 flex items-center gap-2.5">
                                <x-shop::form.control-group.control
                                    type="checkbox"
                                    name="billing.use_for_shipping"
                                    id="use_for_shipping"
                                    for="use_for_shipping"
                                    value="1"
                                    @change="useBillingAddressForShipping = ! useBillingAddressForShipping"
                                    ::checked="!! useBillingAddressForShipping"
                                />

                                <label
                                    class="cursor-pointer select-none text-base text-zinc-500 max-md:text-sm max-sm:text-xs ltr:pl-0 rtl:pr-0"
                                    for="use_for_shipping"
                                >
                                    @lang('shop::app.checkout.onepage.address.same-as-billing')
                                </label>
                            </x-shop::form.control-group>


                            <!-- Customer Shipping Address -->
                            <div
                                class="mt-8"
                                v-if="! useBillingAddressForShipping"
                            >
                                <!-- Shipping Address Header -->
                                <div class="mb-4 flex items-center justify-between">
                                    <h2 class="text-xl font-medium max-md:text-lg max-sm:text-base">
                                        @lang('shop::app.checkout.onepage.address.shipping-address')
                                    </h2>
                                </div>

                                <!-- Saved Customer Addresses Cards -->
                                <div class="mb-2 grid grid-cols-2 gap-5 max-1060:grid-cols-[1fr] max-lg:grid-cols-2 max-md:mt-4 max-md:grid-cols-1">
                                    <div
                                        class="relative max-w-[414px] cursor-pointer select-none rounded-xl border border-zinc-200 p-0 max-md:flex-wrap max-md:rounded-lg"
                                        v-for="address in customerSavedAddresses.shipping"
                                    >
                                        <!-- Actions -->
                                        <div class="absolute top-5 flex gap-5 ltr:right-5 rtl:left-5">
                                            <x-shop::form.control-group class="!mb-0 flex items-center gap-2.5">
                                                <x-shop::form.control-group.control
                                                    type="radio"
                                                    name="shipping.id"
                                                    ::id="`shipping_address_id_${address.id}`"
                                                    ::for="`shipping_address_id_${address.id}`"
                                                    ::value="address.id"
                                                    v-model="selectedAddresses.shipping_address_id"
                                                    rules="required"
                                                    label="{{ trans('shop::app.checkout.onepage.address.shipping-address') }}"
                                                />
                                            </x-shop::form.control-group>

                                            <!-- Edit Icon -->
                                            <span
                                                class="icon-edit cursor-pointer text-2xl"
                                                @click="
                                                    selectedAddressForEdit = address;
                                                    activeAddressForm = 'shipping';
                                                    saveAddress = address.address_type == 'customer'
                                                "
                                            ></span>
                                        </div>

                                        <!-- Details -->
                                        <label
                                            class="block cursor-pointer rounded-xl p-5 max-md:rounded-lg"
                                            :for="`shipping_address_id_${address.id}`"
                                        >
                                            <span class="icon-checkout-address text-6xl text-navyBlue max-sm:text-5xl"></span>

                                            <div class="flex items-center justify-between">
                                                <p class="text-base font-medium">
                                                    @{{ address.first_name + ' ' + address.last_name }}

                                                    <template v-if="address.company_name">
                                                        (@{{ address.company_name }})
                                                    </template>
                                                </p>
                                            </div>

                                            <p class="mt-6 text-sm text-zinc-500 max-md:mt-2 max-sm:mt-0">
                                                <template v-if="address.address">
                                                    @{{ address.address.join(' ') }}<template v-if="address.warehouse"> @{{ address.warehouse }}</template>,
                                                </template>
                                                <template v-else-if="address.warehouse">
                                                    @{{ address.warehouse }},
                                                </template>

                                                @{{ address.city }},
                                                @{{ address.state }}, @{{ address.country }},
                                                @{{ address.postcode }}
                                            </p>
                                        </label>
                                    </div>

                                    <!-- New Address Card -->
                                    <div
                                        class="flex max-w-[414px] cursor-pointer items-center justify-center rounded-xl border border-zinc-200 p-5 max-md:flex-wrap max-md:rounded-lg"
                                        @click="selectedAddressForEdit = null; activeAddressForm = 'shipping'"
                                        v-if="! cart.shipping_address"
                                    >
                                        <div
                                            class="flex items-center gap-x-2.5"
                                            role="button"
                                            tabindex="0"
                                        >
                                            <span
                                                class="icon-plus rounded-full border border-black p-2.5 text-3xl max-sm:p-2"
                                                role="presentation"
                                            ></span>

                                            <p class="text-base">@lang('shop::app.checkout.onepage.address.add-new-address')</p>
                                        </div>
                                    </div>
                                </div>

                                <x-shop::form.control-group.error name="shipping.id" />
                            </div>
                        </template>

                        <!-- Proceed Button -->
                        <div class="mt-4 flex justify-end max-md:my-4">
                            <x-shop::button
                                class="primary-button rounded-2xl px-11 py-3 max-md:rounded-lg max-sm:w-full max-sm:max-w-full max-sm:py-1.5"
                                :title="trans('shop::app.checkout.onepage.address.proceed')"
                                ::loading="isStoring"
                                ::disabled="isStoring"
                            />
                        </div>
                    </form>
                </x-shop::form>
            </template>

            <!-- Create/Edit Address Form -->
            <template v-else>
                <x-shop::form
                    v-slot="{ meta, errors, handleSubmit }"
                    as="div"
                >
                    <form @submit="handleSubmit($event, updateOrCreateAddress)">
                        <!-- Billing Address Header -->
                        <div class="mb-4 flex items-center justify-between">
                            <h2 class="text-xl font-medium max-md:text-base max-sm:font-normal">
                                <template v-if="activeAddressForm == 'billing'">
                                    @lang('shop::app.checkout.onepage.address.billing-address')
                                </template>

                                <template v-else>
                                    @lang('shop::app.checkout.onepage.address.shipping-address')
                                </template>
                            </h2>

                            <span
                                class="flex cursor-pointer justify-end"
                                v-show="customerSavedAddresses.billing.length && ['billing', 'shipping'].includes(activeAddressForm)"
                                @click="selectedAddressForEdit = null; activeAddressForm = null"
                            >
                                <span class="icon-arrow-left text-2xl max-md:hidden"></span>

                                @lang('shop::app.checkout.onepage.address.back')
                            </span>
                        </div>
                        
                        <!-- Address Form Vue Component -->
                        <v-checkout-address-form
                            :control-name="activeAddressForm"
                            :address="selectedAddressForEdit || undefined"
                        ></v-checkout-address-form>

                        <!-- Save Address to Address Book Checkbox -->
                        <x-shop::form.control-group class="!mb-0 flex items-center gap-2.5">
                            <x-shop::form.control-group.control
                                type="checkbox"
                                ::name="activeAddressForm + '.save_address'"
                                id="save_address"
                                for="save_address"
                                value="1"
                                v-model="saveAddress"
                                @change="saveAddress = ! saveAddress"
                            />

                            <label
                                class="cursor-pointer select-none text-base text-zinc-500 max-md:text-sm max-sm:text-xs ltr:pl-0 rtl:pr-0"
                                for="save_address"
                            >
                                @lang('shop::app.checkout.onepage.address.save-address')
                            </label>
                        </x-shop::form.control-group>

                        <!-- Save Button -->
                        <div class="mt-4 flex justify-end">
                            <x-shop::button
                                class="primary-button rounded-2xl px-11 py-3 max-md:rounded-lg max-sm:w-full max-sm:max-w-full max-sm:py-1.5"
                                :title="trans('shop::app.checkout.onepage.address.save')"
                                ::loading="isStoring"
                                ::disabled="isStoring"
                            />
                        </div>
                    </form>
                </x-shop::form>
            </template>
        </template>

        <template>
            <input type="hidden" name="billing.area" v-model="billing.area" />
            <input type="hidden" name="billing.city" v-model="billing.city" />
            <input type="hidden" name="billing.warehouse" v-model="billing.warehouse" />
            <input type="hidden" name="billing.state" v-model="billing.state" />
            <input type="hidden" name="shipping.area" v-model="shipping.area" />
            <input type="hidden" name="shipping.city" v-model="shipping.city" />
            <input type="hidden" name="shipping.warehouse" v-model="shipping.warehouse" />
        </template>
    </script>

    <script type="module">
        app.component('v-checkout-address-customer', {
            template: '#v-checkout-address-customer-template',

            props: ['cart'],

            emits: ['processing', 'processed'],

            data() {
                return {
                    customerSavedAddresses: {
                        'billing': [],
                        
                        'shipping': [],
                    },

                    useBillingAddressForShipping: true,

                    activeAddressForm: null,

                    selectedAddressForEdit: null,

                    saveAddress: false,

                    selectedAddresses: {
                        billing_address_id: null,

                        shipping_address_id: null,
                    },

                    isLoading: true,

                    isStoring: false,

                    billing: {
                        area: '',
                        city: '',
                        warehouse: '',
                        state: ''
                    },

                    shipping: {
                        area: '',
                        city: '',
                        warehouse: '',
                        state: ''
                    }
                }
            },

            created() {
                if (this.cart.billing_address) {
                    this.useBillingAddressForShipping = this.cart.billing_address.use_for_shipping;
                }
            },

            mounted() {
                this.getCustomerSavedAddresses();
                
                // Initialize Nova Poshta form when component is mounted
                this.$nextTick(() => {
                    this.initNovaPoshtaForm();
                });
            },

            methods: {
                getCustomerSavedAddresses() {
                    this.$axios.get('{{ route("shop.api.customers.account.addresses.index") }}')
                        .then(response => {
                            console.log('Loaded customer addresses:', response.data.data);
                            
                            this.initializeAddresses('billing', structuredClone(response.data.data));

                            this.initializeAddresses('shipping', structuredClone(response.data.data));

                            console.log('Initialized addresses:', this.customerSavedAddresses);

                            if (! this.customerSavedAddresses.billing.length) {
                                this.activeAddressForm = 'billing';
                            }

                            this.isLoading = false;
                        })
                        .catch((error) => {
                            console.error(error);
                        });
                },

                initializeAddresses(type, addresses) {
                    this.customerSavedAddresses[type] = addresses;

                    let cartAddress = this.cart[type + '_address'];

                    if (! cartAddress) {
                        addresses.forEach(address => {
                            if (address.default_address) {
                                this.selectedAddresses[type + '_address_id'] = address.id;
                            }
                        });

                        return addresses;
                    }

                    if (cartAddress.parent_address_id) {
                        addresses.forEach(address => {
                            if (address.id == cartAddress.parent_address_id) {
                                this.selectedAddresses[type + '_address_id'] = address.id;
                            }
                        });
                    } else {
                        this.selectedAddresses[type + '_address_id'] = cartAddress.id;
                        
                        addresses.unshift(cartAddress);
                    }

                    return addresses;
                },

                updateOrCreateAddress(params, { setErrors }) {
                    this.$emit('processing', 'address');

                    console.log('Original params:', params);
                    
                    // Collect Nova Poshta data from select elements
                    this.collectNovaPoshtaData(params);

                    params = params[this.activeAddressForm];

                    console.log('Updated params with Nova Poshta data:', params);

                    let address = this.customerSavedAddresses[this.activeAddressForm].find(address => {
                        return address.id == params.id;
                    });

                    if (! address) {
                        if (params.save_address) {
                            this.createCustomerAddress(params, { setErrors })
                                .then((response) => {
                                    this.addAddressToList(response.data.data);
                                })
                                .catch((error) => {});
                        } else {
                            this.addAddressToList(params);
                        }

                        return;
                    }

                    if (params.save_address) {
                        if (address.address_type == 'customer') {
                            this.updateCustomerAddress(params.id, params, { setErrors })
                                .then((response) => {
                                    this.updateAddressInList(response.data.data);
                                })
                                .catch((error) => {});
                        } else {
                            this.removeAddressFromList(params);

                            this.createCustomerAddress(params, { setErrors })
                                .then((response) => {
                                    this.addAddressToList(response.data.data);
                                })
                                .catch((error) => {});
                        }
                    } else {
                        this.updateAddressInList(params);
                    }
                },

                addAddressToList(address) {
                    this.cart[this.activeAddressForm + '_address'] = address;

                    this.customerSavedAddresses[this.activeAddressForm].unshift(address);

                    this.selectedAddresses[this.activeAddressForm + '_address_id'] = address.id;

                    this.activeAddressForm = null;
                },

                updateAddressInList(params) {
                    this.customerSavedAddresses[this.activeAddressForm].forEach((address, index) => {
                        if (address.id == params.id) {
                            params = {
                                ...address,
                                ...params,
                            };

                            this.cart[this.activeAddressForm + '_address'] = params;

                            this.customerSavedAddresses[this.activeAddressForm][index] = params;

                            this.selectedAddresses[this.activeAddressForm + '_address_id'] = params.id;

                            this.activeAddressForm = null;
                        }
                    });
                },

                removeAddressFromList(params) {
                    this.customerSavedAddresses[this.activeAddressForm] = this.customerSavedAddresses[this.activeAddressForm].filter(address => address.id != params.id);
                },

                createCustomerAddress(params, { setErrors }) {
                    this.isStoring = true;

                    return this.$axios.post('{{ route("shop.api.customers.account.addresses.store") }}', params)
                        .then((response) => {
                            this.isStoring = false;

                            return response;
                        })
                        .catch(error => {
                            this.isStoring = false;

                            if (error.response.status == 422) {
                                let errors = {};

                                Object.keys(error.response.data.errors).forEach(key => {
                                    errors[this.activeAddressForm + '.' + key] = error.response.data.errors[key];
                                });

                                setErrors(errors);
                            }

                            return Promise.reject(error);
                        });
                },

                updateCustomerAddress(id, params, { setErrors }) {
                    this.isStoring = true;

                    return this.$axios.put('{{ route("shop.api.customers.account.addresses.update") }}/' + id, params)
                        .then((response) => {
                            this.isStoring = false;

                            return response;
                        })
                        .catch(error => {
                            this.isStoring = false;

                            if (error.response.status == 422) {
                                let errors = {};

                                Object.keys(error.response.data.errors).forEach(key => {
                                    errors[this.activeAddressForm + '.' + key] = error.response.data.errors[key];
                                });

                                setErrors(errors);
                            }

                            return Promise.reject(error);
                        });
                },

                addAddressToCart(params, { setErrors }) {
                    console.log('Original params for addAddressToCart:', params);
                    
                    // Collect Nova Poshta data from select elements
                    this.collectNovaPoshtaData(params);

                    let payload = {
                        billing: {
                            ...this.getSelectedAddress('billing', params.billing.id),
                            use_for_shipping: this.useBillingAddressForShipping
                        },
                    };

                    if (params.shipping !== undefined) {
                        payload.shipping = this.getSelectedAddress('shipping', params.shipping.id);
                    }

                    // Merge Nova Poshta data from params into payload
                    if (params.billing) {
                        payload.billing = {
                            ...payload.billing,
                            area: params.billing.area || payload.billing.area,
                            city: params.billing.city || payload.billing.city,
                            warehouse: params.billing.warehouse || payload.billing.warehouse,
                            state: params.billing.state || payload.billing.state
                        };
                    }

                    if (params.shipping && payload.shipping) {
                        payload.shipping = {
                            ...payload.shipping,
                            area: params.shipping.area || payload.shipping.area,
                            city: params.shipping.city || payload.shipping.city,
                            warehouse: params.shipping.warehouse || payload.shipping.warehouse,
                            state: params.shipping.state || payload.shipping.state
                        };
                    }

                    console.log('Updated payload with Nova Poshta data:', payload);

                    this.isStoring = true;

                    this.moveToNextStep();

                    this.$axios.post('{{ route("shop.checkout.onepage.addresses.store") }}', payload)
                        .then((response) => {
                            this.isStoring = false;

                            if (response.data.data.redirect_url) {
                                window.location.href = response.data.data.redirect_url;
                            } else {
                                // Always emit payment methods since shipping is handled automatically
                                // Если response содержит payment_methods, используем их, иначе используем весь объект
                                const paymentData = response.data.data.payment_methods || response.data.data;
                                this.$emit('processed', paymentData);
                            }
                        })
                        .catch(error => {
                            this.isStoring = false;

                            this.$emit('processing', 'address');

                            if (error.response.status == 422) {
                                const billingRegex = /^billing\./;

                                if (Object.keys(error.response.data.errors).some(key => billingRegex.test(key))) {
                                    setErrors({
                                        'billing.id': error.response.data.message
                                    });
                                } else {
                                    setErrors({
                                        'shipping.id': error.response.data.message
                                    });
                                }
                            }
                        });
                },

                getSelectedAddress(type, id) {
                    let address = Object.assign({}, this.customerSavedAddresses[type].find(address => address.id == id));

                    console.log(`Getting selected ${type} address with id ${id}:`, address);

                    if (id == 0) {
                        address.id = null;
                    }

                    const result = {
                        ...address,
                        default_address: 0,
                    };

                    console.log(`Returning ${type} address:`, result);
                    return result;
                },

                moveToNextStep() {
                    // Always go to payment step - shipping is handled automatically
                    this.$emit('processing', 'payment');
                },

                initNovaPoshtaForm() {
                    // Wait for DOM to be ready
                    this.$nextTick(() => {
                        const areaSelect = document.getElementById('nova-poshta-area');
                        const citySelect = document.getElementById('nova-poshta-city');
                        const warehouseSelect = document.getElementById('nova-poshta-warehouse');
                        
                        if (areaSelect && citySelect && warehouseSelect) {
                            console.log('Initializing Nova Poshta form for customer');
                            
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

                showLoading(loadingId) {
                    const loadingElement = document.getElementById(loadingId);
                    if (loadingElement) {
                        loadingElement.classList.remove('hidden');
                    }
                },

                hideLoading(loadingId) {
                    const loadingElement = document.getElementById(loadingId);
                    if (loadingElement) {
                        loadingElement.classList.add('hidden');
                    }
                },

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

                collectNovaPoshtaData(params) {
                    console.log('Collecting Nova Poshta data for params:', params);
                    
                    // Collect billing address Nova Poshta data
                    const billingAreaSelect = document.querySelector('select[name="billing.area"]');
                    const billingCitySelect = document.querySelector('select[name="billing.city"]');
                    const billingWarehouseSelect = document.querySelector('select[name="billing.warehouse"]');
                    
                    console.log('Found select elements:', {
                        billingAreaSelect: billingAreaSelect,
                        billingCitySelect: billingCitySelect,
                        billingWarehouseSelect: billingWarehouseSelect
                    });
                    
                    // If no select elements found, try to get data from the selected address
                    if (!billingAreaSelect && !billingCitySelect && !billingWarehouseSelect) {
                        console.log('No Nova Poshta select elements found, trying to get data from selected address');
                        const selectedBillingAddress = this.customerSavedAddresses.billing.find(addr => 
                            addr.id == params.billing?.id
                        );
                        
                        if (selectedBillingAddress) {
                            console.log('Found selected billing address:', selectedBillingAddress);
                            if (selectedBillingAddress.area) {
                                params.billing.area = selectedBillingAddress.area;
                                params.billing.state = selectedBillingAddress.state;
                            }
                            if (selectedBillingAddress.city) {
                                params.billing.city = selectedBillingAddress.city;
                            }
                            if (selectedBillingAddress.warehouse) {
                                params.billing.warehouse = selectedBillingAddress.warehouse;
                            }
                        }
                    }
                    
                    if (billingAreaSelect && billingAreaSelect.value) {
                        params.billing.area = billingAreaSelect.selectedOptions[0]?.text || billingAreaSelect.value;
                        params.billing.state = billingAreaSelect.selectedOptions[0]?.text || billingAreaSelect.value;
                        console.log('Updated billing area:', params.billing.area);
                    }
                    
                    if (billingCitySelect && billingCitySelect.value) {
                        params.billing.city = billingCitySelect.selectedOptions[0]?.text || billingCitySelect.value;
                        console.log('Updated billing city:', params.billing.city);
                    }
                    
                    if (billingWarehouseSelect && billingWarehouseSelect.value) {
                        params.billing.warehouse = billingWarehouseSelect.selectedOptions[0]?.text || billingWarehouseSelect.value;
                        console.log('Updated billing warehouse:', params.billing.warehouse);
                    }
                    
                    // Collect shipping address Nova Poshta data if not using billing for shipping
                    if (!this.useBillingAddressForShipping && params.shipping) {
                        const shippingAreaSelect = document.querySelector('select[name="shipping.area"]');
                        const shippingCitySelect = document.querySelector('select[name="shipping.city"]');
                        const shippingWarehouseSelect = document.querySelector('select[name="shipping.warehouse"]');
                        
                        // If no select elements found, try to get data from the selected address
                        if (!shippingAreaSelect && !shippingCitySelect && !shippingWarehouseSelect) {
                            console.log('No Nova Poshta select elements found for shipping, trying to get data from selected address');
                            const selectedShippingAddress = this.customerSavedAddresses.shipping.find(addr => 
                                addr.id == params.shipping?.id
                            );
                            
                            if (selectedShippingAddress) {
                                console.log('Found selected shipping address:', selectedShippingAddress);
                                if (selectedShippingAddress.area) {
                                    params.shipping.area = selectedShippingAddress.area;
                                    params.shipping.state = selectedShippingAddress.state;
                                }
                                if (selectedShippingAddress.city) {
                                    params.shipping.city = selectedShippingAddress.city;
                                }
                                if (selectedShippingAddress.warehouse) {
                                    params.shipping.warehouse = selectedShippingAddress.warehouse;
                                }
                            }
                        }
                        
                        if (shippingAreaSelect && shippingAreaSelect.value) {
                            params.shipping.area = shippingAreaSelect.value;
                            params.shipping.state = shippingAreaSelect.selectedOptions[0]?.text || shippingAreaSelect.value;
                        }
                        
                        if (shippingCitySelect && shippingCitySelect.value) {
                            params.shipping.city = shippingCitySelect.value;
                        }
                        
                        if (shippingWarehouseSelect && shippingWarehouseSelect.value) {
                            params.shipping.warehouse = shippingWarehouseSelect.value;
                        }
                    }
                    
                    console.log('Collected Nova Poshta data:', {
                        billing: {
                            area: params.billing.area,
                            city: params.billing.city,
                            warehouse: params.billing.warehouse,
                            state: params.billing.state
                        },
                        shipping: params.shipping ? {
                            area: params.shipping.area,
                            city: params.shipping.city,
                            warehouse: params.shipping.warehouse,
                            state: params.shipping.state
                        } : null
                    });
                }
            }
        });
    </script>
@endPushOnce