<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Maintenance extends Model
{
    protected $fillable = [
        'equipment_id',
        'reported_by',
        'description',
        'status',
        'cost',
        'reported_at',
        'resolved_at',
    ];

    protected function casts(): array
    {
        return [
            'cost' => 'integer',
            'reported_at' => 'datetime',
            'resolved_at' => 'datetime',
        ];
    }

    /**
     * Get equipment
     */
    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }

    /**
     * Get user who reported the maintenance
     */
    public function reportedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reported_by');
    }

    /**
     * Check if maintenance is open
     */
    public function isOpen(): bool
    {
        return $this->status === 'open';
    }

    /**
     * Check if maintenance is in progress
     */
    public function isInProgress(): bool
    {
        return $this->status === 'in_progress';
    }

    /**
     * Check if maintenance is resolved
     */
    public function isResolved(): bool
    {
        return $this->status === 'resolved';
    }

    /**
     * Scope for open maintenances
     */
    public function scopeOpen($query)
    {
        return $query->where('status', 'open');
    }

    /**
     * Scope for in progress maintenances
     */
    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    /**
     * Scope for resolved maintenances
     */
    public function scopeResolved($query)
    {
        return $query->where('status', 'resolved');
    }
}
