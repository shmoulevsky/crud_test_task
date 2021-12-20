<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected const PAGE_LIMIT = 50;
    private const ROLE_ADMIN = 'admin';
    private const ROLE_USER = 'user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
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
    ];

    public static function getPageLimit()
    {
        return static::PAGE_LIMIT;
    }

    public static function getAdminRole() : string
    {
        return static::ROLE_ADMIN;
    }

    public static function getUserRole() : string
    {
        return static::ROLE_USER;
    }

    public function isAdmin() : bool
    {
        return $this->role === self::getAdminRole();
    }

    public function articles()
    {
        return $this->belongsToMany(Article::class);
    }
}
