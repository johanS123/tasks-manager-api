<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'roleId'
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
    ];

    // Implementación de los métodos requeridos por JWTSubject

    public function getJWTIdentifier()
    {
        // Retorna el identificador único del usuario (usualmente el id)
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        // Puedes retornar cualquier reclamo adicional (opcional)
        return [];
    }

    public function hasAnyRole(array $roles)
    {
        return in_array($this->roleId, $roles);
    }

    public function role()
    {
        return $this->belongsTo(Roles::class);
    }
}
