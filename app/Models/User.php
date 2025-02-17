<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
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

    protected $table = 'users';

    protected $fillable = [
      'full_name',
      'avatar',
      'email',
      'password',
      'phone_number',
      'birthday',
      'address',
      'role_id'
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function hasPermission(Permission $permission)
    {
        return !! optional(optional($this->role)->permissions)->contains($permission);
    }

    public function isAdmin()
    {
        $role_admin = config('constants.ROLE_SUPER_ADMIN');
        return $this->role()->where('id', $role_admin)->first();
    }

    public function isBartender()
    {
        $role_bartender = config('constants.ROLE_BARTENDER');
        return $this->role()->where('id', $role_bartender)->first();
    }

}
