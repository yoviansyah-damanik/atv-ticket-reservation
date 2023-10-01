<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Package extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    protected function imagePath(): Attribute
    {
        return new Attribute(
            get: fn () => $this->image ? asset('/storage/' . $this->image) : asset('branding-assets/img/package-default.png')
        );
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(ReservationDetail::class);;
    }
}
