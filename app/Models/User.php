<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

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

    /**
     * Get the transactions for the user
     *
     *
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * set the user's name
     *
     * @param  string $value
     * @return void
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = Str::title($value);
    }

    /**
     * set the user's username
     *
     * @param  string $value
     * @return void
     */
    public function setUsernameAttribute($value)
    {
        $this->attributes['username'] = strtolower($value);
    }

    /**
     * get the user's roles with custom property
     *
     * @return string
     */
    public function getRolesAttribute($value)
    {
        return json_decode($value);
    }

    /**
     * get the user's complete profile with custom property
     *
     * @return bool
     */
    public function getIsCompleteProfileAttribute()
    {
        return $this->phone && $this->address;
    }

    /**
     * get the user's avatar with custom directory path
     *
     * @return mixed
     */
    public function getAvatar()
    {
        return ($this->avatar) ? asset("/storage/avatars/$this->avatar") : 'https://ui-avatars.com/api/?name=' . Str::of($this->name)->replace(' ', '+') . '&rounded=true' . '&bold=true';
    }
}
