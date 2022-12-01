<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class, 'coupon_id');
    }

    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id');
    }

    public function rating()
    {
        return $this->hasOne(Rating::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, (new OrderProduct())->getTable())
            ->withPivot('quantity')
            ->withTimestamps();
    }

    public function additionals()
    {
        return $this->belongsToMany(Additional::class, (new AdditionalOrder())->getTable());
    }
}
