<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UnitUsage extends Model
{
    use HasFactory;
    protected $fillable = ['reservation_id', 'unit_id'];

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function reservation_detail(): BelongsTo
    {
        return $this->belongsTo(ReservationDetail::class);
    }
}
