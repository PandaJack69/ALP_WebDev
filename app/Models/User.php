<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',                // From the default User model
        'email',               // From the default User model
        'password',            // From both models
        // 'username',            // From the custom model
        'merchant_password',   // From the custom model
        'current_role',        // From the custom model
        'profile_picture',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',            // From both models
        'merchant_password',   // From the custom model
        'remember_token',      // From the default User model
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime', // From the default User model
        'password' => 'hashed',           // From the default User model
    ];

    /**
     * Relationships
     */
    // public function roles()
    // {
    //     return $this->belongsToMany(Role::class, 'user_roles'); // From the custom model
    // }

    public function carts()
    {
        return $this->hasMany(Cart::class); // From the custom model
    }

    public function orders()
    {
        return $this->hasMany(Order::class); // From the custom model
    }

    public function merchant()
    {
        return $this->hasOne(Merchant::class, 'user_id', 'id');
    }
    // new
    // If you want to access stores directly through the user:
    public function stores()
    {
        return $this->hasManyThrough(Store::class, Merchant::class, 'user_id', 'merchant_id');
    }

    /**
     * Role Management
     */
    public function hasRole($role): bool
    {
        return $this->roles->contains('name', $role); // From the custom model
    }

    public function switchRole($role): void
    {
        $roleId = Userrole::where('name', $role)->value('id'); // From the custom model

        if ($roleId) {
            $this->roles()->sync([$roleId]);
            $this->current_role = $role;
            $this->save();
        }
    }
}