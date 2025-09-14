<?php

namespace Webkul\Payment\Payment;

use Illuminate\Support\Facades\Storage;

class CashOnDelivery extends Payment
{
    /**
     * Payment method code.
     *
     * @var string
     */
    protected $code = 'cashondelivery';

    /**
     * Get redirect url.
     *
     * @return string
     */
    public function getRedirectUrl() {}

    /**
     * Is available.
     *
     * @return bool
     */
    public function isAvailable()
    {
        if (! $this->cart) {
            $this->setCart();
        }

        return $this->getConfigData('active') && $this->cart?->haveStockableItems();
    }

    /**
     * Get payment method title.
     *
     * @return string
     */
    public function getTitle()
    {
        return trans('shop::app.checkout.onepage.payment.cash-on-delivery') ?: $this->getConfigData('title');
    }

    /**
     * Get payment method description.
     *
     * @return string
     */
    public function getDescription()
    {
        return trans('shop::app.checkout.onepage.payment.cash-on-delivery') ?: $this->getConfigData('description');
    }

    /**
     * Get payment method image.
     *
     * @return array
     */
    public function getImage()
    {
        $url = $this->getConfigData('image');

        return $url ? Storage::url($url) : bagisto_asset('images/cash-on-delivery.png', 'shop');
    }
}
