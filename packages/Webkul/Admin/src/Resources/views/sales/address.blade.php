<div class="flex flex-col">
    <p class="font-semibold leading-6 text-gray-800 dark:text-white">
        {{ $address->company_name ?? '' }}
    </p>

    <p class="font-semibold leading-6 text-gray-800 dark:text-white">
        {{ $address->name }}
    </p>

    @if ($address->vat_id)
        <p class="font-semibold leading-6 text-gray-800 dark:text-white">
            {{ $address->vat_id }}
        </p>
    @endif

    <p class="!leading-6 text-gray-600 dark:text-gray-300">
        {{ $address->address }}<br>

        {{ $address->city }}<br>

        {{ $address->state }}<br>

        {{ core()->country_name($address->country) }} @if ($address->postcode) ({{ $address->postcode }}) @endif<br>

        {{ __('admin::app.sales.orders.view.contact') }} : {{ $address->phone }}
    </p>

    @if ($address->area || $address->warehouse)
        <div class="mt-2 p-2 bg-blue-50 dark:bg-blue-900/20 rounded border-l-4 border-blue-400">
            <p class="text-sm font-semibold text-blue-800 dark:text-blue-200 mb-1">
                {{ __('admin::app.sales.orders.view.nova-poshta-info') }}
            </p>
            
            @if ($address->area)
                <p class="text-sm text-blue-700 dark:text-blue-300">
                    <strong>{{ __('admin::app.sales.orders.view.nova-poshta-area') }}:</strong> {{ $address->area }}
                </p>
            @endif
            
            @if ($address->city)
                <p class="text-sm text-blue-700 dark:text-blue-300">
                    <strong>{{ __('admin::app.sales.orders.view.nova-poshta-city') }}:</strong> {{ $address->city }}
                </p>
            @endif
            
            @if ($address->warehouse)
                <p class="text-sm text-blue-700 dark:text-blue-300">
                    <strong>{{ __('admin::app.sales.orders.view.nova-poshta-warehouse') }}:</strong> {{ $address->warehouse }}
                </p>
            @endif
        </div>
    @endif
</div>