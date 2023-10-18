<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaymentVendor extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public $incrementing = false;
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id = 'PV' . Carbon::now()->year . sprintf('%04d', (int) self::count() + 1);
        });
    }
    protected function imagePath(): Attribute
    {
        return new Attribute(
            get: fn () => $this->image ? asset('/storage/' . $this->image) : asset('branding-assets/img/payment-vendor-default.png')
        );
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }
}
