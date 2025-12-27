<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class UpdateRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'resident_id',
        'status',
        'requested_changes',
        'reason',
        'reviewed_by',
        'reviewed_at',
    ];

    protected function casts(): array
    {
        return [
            'requested_changes' => 'array',
            'reviewed_at' => 'datetime',
        ];
    }

    /**
     * Get the resident that owns the update request.
     */
    public function resident(): BelongsTo
    {
        return $this->belongsTo(Resident::class);
    }

    /**
     * Get the user who reviewed the request.
     */
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    /**
     * Get the notification for this update request.
     */
    public function notification(): HasOne
    {
        return $this->hasOne(\App\Models\Notification::class);
    }
}
