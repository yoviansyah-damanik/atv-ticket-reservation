<?php

namespace App\Models;

use App\Models\ReservationDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Unit extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected function imagePath(): Attribute
    {
        return new Attribute(
            get: fn () => $this->image ? asset('public/' . $this->image) : asset('branding-assets/img/unit-default.png')
        );
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(ReservationDetail::class);;
    }
}
