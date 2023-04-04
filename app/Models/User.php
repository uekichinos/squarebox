<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Lab404\Impersonate\Models\Impersonate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, Impersonate;

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

    /**
     * Change created date format
     *
     * @var datetime
     */
    public function getCreatedAtAttribute($value) {
        return date('d M Y, H:i a', strtotime($value));
    }

    /**
     * Change updated date format
     *
     * @var datetime
     */
    public function getUpdatedAtAttribute($value) {
        return date('d M Y, H:i a', strtotime($value));
    }

    /**
     * Change last password update date format
     *
     * @var datetime
     */
    public function getPasswordUpdatedAtAttribute($value) {
        return (empty($value) ? '-' : date('d M Y, H:i a', strtotime($value)));
    }
}
