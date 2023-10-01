<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Enums\ReservationType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reservation extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id = Carbon::now()->format('dmY') . Str::upper(Str::random(8));
        });
    }

    protected function scopeWaitingStatus($query)
    {
        return $query->where('status', ReservationType::WaitingForPayment);
    }

    protected function scopeCompletedStatus($query)
    {
        return $query->where('status', ReservationType::Completed);
    }

    protected function scopeCanceledStatus($query)
    {
        return $query->where('status', ReservationType::Canceled);
    }

    protected function scopeReadyStatus($query)
    {
        return $query->where('status', ReservationType::ReadyForAction);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function details(): HasMany
    {
        return $this->hasMany(ReservationDetail::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }

    public function unit_usages(): HasMany
    {
        return $this->hasMany(UnitUsage::class);
    }
}
