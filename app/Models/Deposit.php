<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        'duration',
        'accrue_times'
    ];
    
    protected $attributes = [
        'status' => self::STATUS_ACTIVE
    ];

    /**
     * User model deposit belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Waller model deposit belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function wallet()
    {
        return $this->belongsTo(Wallet::class, 'wallet_id', 'id');
    }

}
