{!! view_render_event('bagisto.shop.checkout.onepage.address.guest.before') !!}

<!-- Guest Address Vue Component -->
<v-checkout-address-guest
    :cart="cart"
    @processing="stepForward"
    @processed="stepProcessed"
></v-checkout-address-guest>

{!! view_render_event('bagisto.shop.checkout.onepage.address.guest.after') !!}

@include('shop::checkout.onepage.address.form')

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-checkout-address-guest-template"
    >
        <!-- Address Form -->
        <x-shop::form
            v-slot="{ meta, errors, handleSubmit }"
            as="div"
        >
            <form @submit="handleSubmit($event, addAddress)">
                <!-- Guest Billing Address -->
                <div class="mb-4">
                    {!! view_render_event('bagisto.shop.checkout.onepage.address.guest.billing.before') !!}

                    <!-- Billing Address Header -->
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-medium max-md:text-lg max-sm:text-base">
                            @lang('shop::app.checkout.onepage.address.billing-address')
                        </h2>
                    </div>
                
                    <!-- Billing Address Form -->
                    <v-checkout-address-form
                        control-name="billing"
                        :address="cart.billing_address || undefined"
                    ></v-checkout-address-form>

                    <!-- Use for Shipping Checkbox -->
                    <x-shop::form.control-group
                        class="!mb-0 flex items-center gap-2.5"
                        v-if="cart.have_stockable_items"
                    >
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

                    {!! view_render_event('bagisto.shop.checkout.onepage.address.guest.billing.after') !!}
                </div>

                <!-- Guest Shipping Address -->
                <template v-if="cart.have_stockable_items">
                    <div
                        class="mt-8"
                        v-if="! useBillingAddressForShipping"
                    >
                        {!! view_render_event('bagisto.shop.checkout.onepage.address.guest.shipping.before') !!}

                        <!-- Shipping Address Header -->
                        <div class="flex items-center justify-between">
                            <h2 class="text-xl font-medium max-md:text-lg max-sm:text-base">
                                @lang('shop::app.checkout.onepage.address.shipping-address')
                            </h2>
                        </div>
                    
                        <!-- Shipping Address Form -->
                        <v-checkout-address-form
                            control-name="shipping"
                            :address="cart.shipping_address || undefined"
                        ></v-checkout-address-form>

                        {!! view_render_event('bagisto.shop.checkout.onepage.address.guest.shipping.after') !!}
                    </div>
                </template>

                <!-- Proceed Button -->
                <div class="mt-4 flex justify-end">
                    <x-shop::button
                        class="primary-button rounded-2xl px-11 py-3 max-md:w-full max-md:max-w-full max-md:rounded-lg"
                        :title="trans('shop::app.checkout.onepage.address.proceed')"
                        ::loading="isStoring"
                        ::disabled="isStoring"
                    />
                </div>
            </form>
        </x-shop::form>
    </script>

    <script type="module">
        app.component('v-checkout-address-guest', {
            template: '#v-checkout-address-guest-template',

            props: ['cart'],

            emits: ['processing', 'processed'],

            data() {
                return {
                    useBillingAddressForShipping: true,

                    isStoring: false,
                }
            },

            created() {
                if (this.cart.billing_address) {
                    this.useBillingAddressForShipping = this.cart.billing_address.use_for_shipping;
                }
            },

            methods: {
                addAddress(params, { setErrors }) {
                    this.isStoring = true;

                    console.log('Original params:', params);
                    
                    // Collect Nova Poshta data from select elements
                    this.collectNovaPoshtaData(params);
                    
                    params['billing']['use_for_shipping'] = this.useBillingAddressForShipping;

                    console.log('Updated params with Nova Poshta data:', params);

                    this.moveToNextStep();

                    this.$axios.post('{{ route("shop.checkout.onepage.addresses.store") }}', params)
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

                            if (error.response.status == 422) {
                                setErrors(error.response.data.errors);
                            }
                        });
                },

                moveToNextStep() {
                    // Always go to payment step - shipping is handled automatically
                    this.$emit('processing', 'payment');
                },

                collectNovaPoshtaData(params) {
                    // Collect billing address Nova Poshta data
                    const billingAreaSelect = document.querySelector('select[name="billing.area"]');
                    const billingCitySelect = document.querySelector('select[name="billing.city"]');
                    const billingWarehouseSelect = document.querySelector('select[name="billing.warehouse"]');
                    
                    if (billingAreaSelect && billingAreaSelect.value) {
                        params.billing.area = billingAreaSelect.selectedOptions[0]?.text || billingAreaSelect.value;
                        params.billing.state = billingAreaSelect.selectedOptions[0]?.text || billingAreaSelect.value;
                    }
                    
                    if (billingCitySelect && billingCitySelect.value) {
                        params.billing.city = billingCitySelect.selectedOptions[0]?.text || billingCitySelect.value;
                    }
                    
                    if (billingWarehouseSelect && billingWarehouseSelect.value) {
                        params.billing.warehouse = billingWarehouseSelect.selectedOptions[0]?.text || billingWarehouseSelect.value;
                    }
                    
                    // Collect shipping address Nova Poshta data if not using billing for shipping
                    if (!this.useBillingAddressForShipping && params.shipping) {
                        const shippingAreaSelect = document.querySelector('select[name="shipping.area"]');
                        const shippingCitySelect = document.querySelector('select[name="shipping.city"]');
                        const shippingWarehouseSelect = document.querySelector('select[name="shipping.warehouse"]');
                        
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