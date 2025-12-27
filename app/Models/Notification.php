<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'gate_log_id',
        'update_request_id',
        'is_read',
    ];

    protected function casts(): array
    {
        return [
            'is_read' => 'boolean',
        ];
    }

    /**
     * Get the user that owns the notification.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the gate log associated with the notification.
     */
    public function gateLog(): BelongsTo
    {
        return $this->belongsTo(GateLog::class);
    }

    /**
     * Get the update request associated with the notification.
     */
    public function updateRequest(): BelongsTo
    {
        return $this->belongsTo(UpdateRequest::class);
    }
}
