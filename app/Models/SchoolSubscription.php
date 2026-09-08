<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SchoolSubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_name',
        'school_email',
        'school_phone',
        'school_address',
        'package_id',
        'admin_user_id',
        'start_date',
        'end_date',
        'status',
        'rejection_reason',
        'approved_by',
        'approved_at',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'approved_at' => 'datetime',
        ];
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(SubscriptionPackage::class, 'package_id');
    }

    public function adminUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_user_id');
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(PaymentHistory::class, 'subscription_id');
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'Menunggu',
            'active' => 'Aktif',
            'rejected' => 'Ditolak',
            'expired' => 'Kedaluwarsa',
            'cancelled' => 'Dibatalkan',
            default => ucfirst($this->status),
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'yellow',
            'active' => 'green',
            'rejected' => 'red',
            'expired' => 'slate',
            'cancelled' => 'orange',
            default => 'slate',
        };
    }
}
