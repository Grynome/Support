<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Role;
use App\Models\Dept;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $table = 'hgt_users';
    protected $fillable = [
        'id',
        'nik',
        'profile',
        'cover',
        'full_name',
        'username',
        'gender',
        'role',
        'depart',
        'service_point',
        'chanel',
        'email',
        'phone',
        'work_type',
        'verify',
        'verify_at',
        'password',
        'Terms'
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
    protected $guarded = [];
    public function roles(){
        return $this->belongsTo(Role::class, 'role', 'id');
    }
    public function dept(){
        return $this->belongsTo(Dept::class, 'depart', 'id');
    }

}