<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Equipment extends Model
{
    protected $table = 'equipments';

    protected $fillable = [
        'name',
        'brand',
        'model',
        'serial_number',
        'category_id',
        'status',
        'purchase_date',
        'warranty_duration',
        'warranty_expires_at',
        'image_path',
        'details',
    ];

    protected function casts(): array
    {
        return [
            'purchase_date' => 'date',
            'warranty_duration' => 'integer',
            'warranty_expires_at' => 'date',
            'details' => 'array',
        ];
    }

    /**
     * Calculate warranty expiration date
     */
    protected static function boot(): void
    {
        parent::boot();

        static::creating(function ($equipment) {
            if ($equipment->purchase_date && $equipment->warranty_duration && !$equipment->warranty_expires_at) {
                $equipment->warranty_expires_at = Carbon::parse($equipment->purchase_date)
                    ->addMonths((int) $equipment->warranty_duration);
            }
        });

        static::updating(function ($equipment) {
            if ($equipment->isDirty(['purchase_date', 'warranty_duration']) && $equipment->purchase_date && $equipment->warranty_duration) {
                $equipment->warranty_expires_at = Carbon::parse($equipment->purchase_date)
                    ->addMonths((int) $equipment->warranty_duration);
            }
        });
    }

    /**
     * Check if warranty is expiring soon (within 30 days)
     */
    public function isWarrantyExpiringSoon(): bool
    {
        if (!$this->warranty_expires_at) {
            return false;
        }

        return Carbon::parse($this->warranty_expires_at)->diffInDays(now()) <= 30
            && Carbon::parse($this->warranty_expires_at)->isFuture();
    }

    /**
     * Check if warranty is expired
     */
    public function isWarrantyExpired(): bool
    {
        if (!$this->warranty_expires_at) {
            return false;
        }

        return Carbon::parse($this->warranty_expires_at)->isPast();
    }

    /**
     * Get category
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get assignments
     */
    public function assignments(): HasMany
    {
        return $this->hasMany(Assignment::class);
    }

    /**
     * Get current assignment (not returned)
     */
    public function currentAssignment()
    {
        return $this->hasOne(Assignment::class)->whereNull('returned_at');
    }

    /**
     * Get maintenances
     */
    public function maintenances(): HasMany
    {
        return $this->hasMany(Maintenance::class);
    }

    /**
     * Get active maintenances
     */
    public function activeMaintenances(): HasMany
    {
        return $this->hasMany(Maintenance::class)
            ->whereIn('status', ['open', 'in_progress']);
    }

    /**
     * Scope for available equipments
     */
    public function scopeAvailable($query)
    {
        return $query->where('status', 'available');
    }

    /**
     * Scope for assigned equipments
     */
    public function scopeAssigned($query)
    {
        return $query->where('status', 'assigned');
    }

    /**
     * Scope for broken equipments
     */
    public function scopeBroken($query)
    {
        return $query->where('status', 'broken');
    }
}
