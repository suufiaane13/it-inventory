<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'prenom',
        'email',
        'tel',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

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

    /**
     * Get full name attribute (name + prenom)
     */
    public function getFullNameAttribute(): string
    {
        $name = $this->name ?? '';
        $prenom = $this->prenom ?? '';
        
        if ($prenom) {
            return trim($name . ' ' . $prenom);
        }
        
        return $name;
    }

    /**
     * Check if user is super admin
     */
    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    /**
     * Check if user is technician
     */
    public function isTechnician(): bool
    {
        return $this->role === 'technician';
    }

    /**
     * Get assignments made by this user
     */
    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }

    /**
     * Get maintenances reported by this user
     */
    public function reportedMaintenances()
    {
        return $this->hasMany(Maintenance::class, 'reported_by');
    }
}
