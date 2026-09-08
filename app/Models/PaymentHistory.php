<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'subscription_id',
        'amount',
        'payment_method',
        'status',
        'payment_proof',
        'notes',
        'payment_date',
        'confirmed_by',
        'confirmed_at',
    ];

    protected function casts(): array
    {
        return [
            'payment_date' => 'date',
            'confirmed_at' => 'datetime',
        ];
    }

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(SchoolSubscription::class, 'subscription_id');
    }

    public function confirmedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'confirmed_by');
    }

    public function getAmountFormattedAttribute(): string
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'Menunggu',
            'paid' => 'Lunas',
            'failed' => 'Gagal',
            'refunded' => 'Dikembalikan',
            default => ucfirst($this->status),
        };
    }

    public function getPaymentMethodLabelAttribute(): string
    {
        return match ($this->payment_method) {
            'transfer' => 'Transfer Bank',
            'cash' => 'Tunai',
            'virtual_account' => 'Virtual Account',
            'other' => 'Lainnya',
            default => ucfirst($this->payment_method),
        };
    }
}
