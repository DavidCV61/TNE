<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens; // Sanctum

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
    ];

    protected $hidden = [
        'password',
    ];


    public function role()
    {
        return $this->belongsTo(Role::class);
    }


    public function getRoleName(): string
    {
        return $this->role->name ?? 'invitado';
    }
}
