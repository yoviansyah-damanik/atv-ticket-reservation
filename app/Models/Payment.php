<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected function proofPath(): Attribute
    {
        return new Attribute(
            get: fn () => $this->proof_of_payment ? asset($this->proof_of_payment) : asset('branding-assets/img/proof-default.png')
        );
    }

    public function reservation(): BelongsTo
    {
        return $this->belongsTo(Reservation::class);
    }

    public function payment_vendor(): BelongsTo
    {
        return $this->belongsTo(PaymentVendor::class);
    }
}
