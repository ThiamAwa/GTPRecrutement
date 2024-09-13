<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    use HasRoles;
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id'
    ];


    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function isManager()
    {
        return $this->role && $this->role->name === 'manager';
    }

    public function isClient()
    {
        return $this->role && $this->role->name === 'client';
    }

    public function isConsultant()
    {
        return $this->role && $this->role->name === 'consultant';
    }

    public function client()
    {
        return $this->hasOne(Client::class);
    }

    public function consultant()
    {
        return $this->hasOne(Consultant::class);
    }



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
}
