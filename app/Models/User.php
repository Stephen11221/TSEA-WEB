<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role', 'role_id', 'phone', 'bio', 'avatar', 'status', 'is_verified', 'verified_at', 'last_login_at', 'last_login_ip'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Check if user is admin
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is regular user / job seeker
     */
    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    /**
     * Check if user is employer
     */
    public function isEmployer(): bool
    {
        return $this->role === 'employer';
    }

    /**
     * Check if user is instructor
     */
    public function isInstructor(): bool
    {
        return $this->role === 'instructor';
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function passport()
    {
        return $this->hasOne(UserPassport::class);
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * Get the user's notifications.
     * This overrides the default Notifiable trait relationship to use the custom table.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function employer()
    {
        return $this->hasOne(Employer::class);
    }
}
