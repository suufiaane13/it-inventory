<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Assignment extends Model
{
    protected $fillable = [
        'equipment_id',
        'employee_id',
        'user_id',
        'assigned_at',
        'returned_at',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'assigned_at' => 'datetime',
            'returned_at' => 'datetime',
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
     * Get employee
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * Get user who made the assignment
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if assignment is active (not returned)
     */
    public function isActive(): bool
    {
        return is_null($this->returned_at);
    }

    /**
     * Get duration in days
     */
    public function getDurationInDaysAttribute(): ?int
    {
        if (!$this->assigned_at) {
            return null;
        }

        $endDate = $this->returned_at ?? now();
        return Carbon::parse($this->assigned_at)->diffInDays($endDate);
    }
}
