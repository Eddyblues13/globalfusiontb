<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Hash;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'amount',
        'fee',
        'net_amount',
        'status',
        'account_name',
        'account_number',
        'bank_name',
        'routing_number',
        'paypal_email',
        'wallet_type',
        'wallet_address',
        'crypto_type',
        'front_cheque_path',
        'loan_type',
        'repayment_period',
        'loan_reason',
        'description',
        'reference_id',
        'transaction_pin',
        'processed_at'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'fee' => 'decimal:2',
        'net_amount' => 'decimal:2',
        'processed_at' => 'datetime',
    ];

    // Transaction types
    const TYPE_BANK_TRANSFER = 'bank_transfer';
    const TYPE_PAYPAL_WITHDRAWAL = 'paypal_withdrawal';
    const TYPE_CRYPTO_DEPOSIT = 'crypto_deposit';
    const TYPE_CRYPTO_WITHDRAWAL = 'crypto_withdrawal';
    const TYPE_CHECK_DEPOSIT = 'check_deposit';
    const TYPE_LOAN_REQUEST = 'loan_request';

    // Statuses
    const STATUS_PENDING = 'pending';
    const STATUS_PROCESSING = 'processing';
    const STATUS_COMPLETED = 'completed';
    const STATUS_FAILED = 'failed';
    const STATUS_CANCELLED = 'cancelled';

    /**
     * Relationship with User model
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope for pending transactions
     */
    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }

    /**
     * Scope for completed transactions
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', self::STATUS_COMPLETED);
    }

    /**
     * Scope for transactions by type
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Check if transaction is pending
     */
    public function isPending(): bool
    {
        return $this->status === self::STATUS_PENDING;
    }

    /**
     * Check if transaction is completed
     */
    public function isCompleted(): bool
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    /**
     * Mark transaction as processing
     */
    public function markAsProcessing(): bool
    {
        return $this->update(['status' => self::STATUS_PROCESSING]);
    }

    /**
     * Mark transaction as completed
     */
    public function markAsCompleted(): bool
    {
        return $this->update([
            'status' => self::STATUS_COMPLETED,
            'processed_at' => now()
        ]);
    }

    /**
     * Mark transaction as failed
     */
    public function markAsFailed(): bool
    {
        return $this->update(['status' => self::STATUS_FAILED]);
    }

    /**
     * Verify transaction PIN
     */
    public function verifyPin($pin): bool
    {
        return Hash::check($pin, $this->transaction_pin);
    }

    /**
     * Generate a unique reference ID
     */
    public static function generateReferenceId(): string
    {
        return 'TXN' . now()->format('YmdHis') . rand(1000, 9999);
    }

    /**
     * Get transaction type label
     */
    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            self::TYPE_BANK_TRANSFER => 'Bank Transfer',
            self::TYPE_PAYPAL_WITHDRAWAL => 'PayPal Withdrawal',
            self::TYPE_CRYPTO_DEPOSIT => 'Crypto Deposit',
            self::TYPE_CRYPTO_WITHDRAWAL => 'Crypto Withdrawal',
            self::TYPE_CHECK_DEPOSIT => 'Check Deposit',
            self::TYPE_LOAN_REQUEST => 'Loan Request',
            default => ucfirst(str_replace('_', ' ', $this->type))
        };
    }

    /**
     * Calculate net amount based on fee percentage
     */
    public static function calculateNetAmount(float $amount, float $feePercentage = 0): array
    {
        $fee = $amount * ($feePercentage / 100);
        $netAmount = $amount - $fee;

        return [
            'amount' => $amount,
            'fee' => round($fee, 2),
            'net_amount' => round($netAmount, 2)
        ];
    }

    public function setTransactionPinAttribute($value)
    {
        $this->attributes['transaction_pin'] = Hash::make($value);
    }
}
