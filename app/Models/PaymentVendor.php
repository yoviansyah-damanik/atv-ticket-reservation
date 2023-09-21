<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentVendor extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected function imagePath(): Attribute
    {
        return new Attribute(
            get: fn () => $this->image ? asset($this->image) : asset('branding-assets/img/payment-vendor-default.png')
        );
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
