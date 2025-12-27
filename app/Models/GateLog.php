<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class GateLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'resident_id',
        'plate_number',
        'owner_name',
        'car_model',
        'car_color',
        'status',
        'image_path',
        'timestamp',
    ];

    protected function casts(): array
    {
        return [
            'timestamp' => 'datetime',
        ];
    }

    /**
     * Get the resident that owns the gate log.
     */
    public function resident(): BelongsTo
    {
        return $this->belongsTo(Resident::class);
    }

    /**
     * Get the notification for this gate log.
     */
    public function notification(): HasOne
    {
        return $this->hasOne(\App\Models\Notification::class);
    }
}
