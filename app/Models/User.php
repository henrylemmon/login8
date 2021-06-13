<?php

namespace App\Models;

use Illuminate\Support\Facades\Hash;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /*public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }*/

    public function roles()
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    /**
     * Check if the user has a role
     * @param string $role
     * @return bool
     */
    public function hasAnyRole(string $role): bool
    {
        return null !== $this->roles()->where('name', $role)->first();
    }

    /**
     * Check if the user has any of the given roles
     * @param array $roles
     * @return bool
     */
    public function hasAnyRoles(array $roles): bool
    {
        return null !== $this->roles()->whereIn('name', $roles)->first();
    }
}
