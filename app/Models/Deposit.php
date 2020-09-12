<?php

namespace App\Models;

use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Deposit extends Model
{
    use HasFactory, SoftDeletes;

    const STATUS_ACTIVE = 1;
    const STATUS_CLOSED = 0;

    /**
     * Mass assignable properties
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'wallet_id',
        'invested_amount',
        'percentage',
        'status',
        'accrue_times'
    ];
    
    protected $attributes = [
        'status' => self::STATUS_ACTIVE
    ];

    /**
     * User model deposit belongs to
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Waller model deposit belongs to
     *
     * @return BelongsTo
     */
    public function wallet()
    {
        return $this->belongsTo(Wallet::class, 'wallet_id', 'id');
    }

    /**
     * Transaction models collection that are related to this model
     *
     * @return HasMany
     */
    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'deposit_id', 'id');
    }

    /**
     * Queryies only active deposits
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeActive($query)
    {
        return $query->whereStatus(self::STATUS_ACTIVE);
    }

    /**
     * Queries only closed deposits
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeClosed($query)
    {
        return $query->whereStatus(self::STATUS_CLOSED);
    }

}
