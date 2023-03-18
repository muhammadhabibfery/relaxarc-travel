<?php

namespace App\Models;

use Illuminate\Support\Str;
use App\Notifications\VerifyEmails;
use Filament\Models\Contracts\HasAvatar;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\ResetPasswordNotifcation;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail, FilamentUser, HasAvatar
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
        'roles' => 'array'
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
        return ($this->avatar) ? asset("/storage/$this->avatar") : 'https://ui-avatars.com/api/?name=' . Str::of($this->name)->replace(' ', '+') . '&rounded=true' . '&bold=true';
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmails);
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotifcation($token));
    }

    /**
     * Get the user's avatar only for admin panel (user who has admin or staff role).
     *
     * @return string
     */
    public function getFilamentAvatarUrl(): ?string
    {
        // return $this->avatar;
        return $this->avatar ? asset("/storage/$this->avatar") : null;
    }

    /**
     * Authenticate user to admin panel.
     *
     * @return bool
     */
    public function canAccessFilament(): bool
    {
        return checkRoles(["ADMIN", 1], $this->roles) && $this->status === 'ACTIVE';
    }
}
