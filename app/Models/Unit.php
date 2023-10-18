<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\ReservationDetail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Unit extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id = 'U' . Carbon::now()->year . sprintf('%04d', (int) self::count() + 1);
        });
    }

    protected function imagePath(): Attribute
    {
        return new Attribute(
            get: fn () => $this->image ? asset('storage/' . $this->image) : asset('branding-assets/img/unit-default.png')
        );
    }

    public function unit_usages(): HasMany
    {
        return $this->hasMany(UnitUsage::class);
    }
}
