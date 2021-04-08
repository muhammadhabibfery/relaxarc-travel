<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username', 'roles', 'phone', 'address', 'avatar', 'status', 'email_verified_at', 'remember_token'
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

    public function getAvatar()
    {
        return ($this->avatar) ? asset('/storage/' . '/' . $this->avatar) : 'https://ui-avatars.com/api/?name=' . Str::of($this->name)->replace(' ', '+') . '&rounded=true' . '&bold=true';
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = Str::title($value);
    }

    public function setUsernameAttribute($value)
    {
        $this->attributes['username'] = strtolower($value);
    }

    public function getRolesAttribute($value)
    {
        return json_decode($value);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
