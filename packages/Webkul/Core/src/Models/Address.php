<?php

namespace Webkul\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Webkul\Core\Contracts\Address as AddressContract;
use Webkul\Customer\Models\Customer;

abstract class Address extends Model implements AddressContract
{
    /**
     * Table.
     *
     * @var string
     */
    protected $table = 'addresses';

    /**
     * Guarded.
     *
     * @var array
     */
    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    /**
     * Fillable.
     *
     * @var array
     */
    protected $fillable = [
        'address_type',
        'customer_id',
        'cart_id',
        'order_id',
        'parent_address_id',
        'first_name',
        'last_name',
        'gender',
        'company_name',
        'address1',
        'address2',
        'city',
        'state',
        'country',
        'postcode',
        'email',
        'phone',
        'vat_id',
        'default_address',
        'use_for_shipping',
        'additional',
        'area',
        'warehouse',
    ];

    /**
     * Castable.
     *
     * @var array
     */
    protected $casts = [
        'use_for_shipping' => 'boolean',
        'default_address'  => 'boolean',
    ];

    /**
     * Get all the attributes for the attribute groups.
     */
    public function getNameAttribute(): string
    {
        return $this->first_name.' '.$this->last_name;
    }

    /**
     * Get the customer record associated with the address.
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
}
