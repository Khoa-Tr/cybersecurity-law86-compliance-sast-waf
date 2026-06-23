<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = [
        'name', 'username', 'email', 'password', 'phone', 'ssn_last4', 'role', 'department', 'join_date', 'status', 'avatar'
    ];

    protected $hidden = [
        //  NOT hiding password or ssn for demo purposes (intentional vuln)
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}
