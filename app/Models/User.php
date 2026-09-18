<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
        'bio',
        'phone',
        'address',
        'email_verified_at',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function loginAttempts()
    {
        return $this->hasMany(LoginAttempt::class);
    }

    public function securityLockouts()
    {
        return $this->hasMany(SecurityLockout::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isLockedOut(): bool
    {
        $activeLockout = $this->securityLockouts()
            ->where('locked_until', '>', now())
            ->latest('locked_until')
            ->first();

        return ! is_null($activeLockout);
    }

    public function isCitizen(): bool
    {
        return $this->role === 'citizen';
    }

    public function recordFailedLogin(string $ipAddress, ?string $userAgent): void
    {
        $this->loginAttempts()->create([
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'attempted_at' => now(),
        ]);

        $recentFailures = $this->loginAttempts()
            ->where('attempted_at', '>=', now()->subHours(24))
            ->count();

        if ($recentFailures >= 5) {
            $this->securityLockouts()->create([
                'locked_until' => now()->addHours(48),
                'reason' => 'Too many failed login attempts',
            ]);
        }
    }
}
