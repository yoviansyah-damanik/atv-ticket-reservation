<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected function imagePath(): Attribute
    {
        return new Attribute(
            get: fn () => $this->image ? asset('/storage/' . $this->image) : asset('branding-assets/img/user-default.png')
        );
    }

    public function isUser(): Attribute
    {
        return new Attribute(
            get: fn () => $this->roles[0]->name == 'User'
        );
    }

    public function roleName(): Attribute
    {
        return new Attribute(
            get: fn () => $this->roles[0]->name
        );
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    public function verified(): HasMany
    {
        return $this->hasMany(Reservation::class, 'verifier_id', 'id');
    }
}
