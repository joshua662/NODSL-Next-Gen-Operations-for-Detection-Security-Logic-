<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Resident extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'age',
        'address',
        'plate_number',
        'car_model',
        'car_color',
        'contact_number',
    ];

    protected function casts(): array
    {
        return [
            'age' => 'integer',
        ];
    }

    /**
     * Get the user that owns the resident.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the gate logs for the resident.
     */
    public function gateLogs(): HasMany
    {
        return $this->hasMany(GateLog::class);
    }

    /**
     * Get the update requests for the resident.
     */
    public function updateRequests(): HasMany
    {
        return $this->hasMany(UpdateRequest::class);
    }
}
