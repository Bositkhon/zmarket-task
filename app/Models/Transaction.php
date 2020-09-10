<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    const TYPE_CREATE_DEPOSIT = 1;
    const TYPE_ACCRUE = 2;
    const TYPE_CLOSE_DEPOSIT = 3;

    /**
     * Mass assignable properties
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'user_id',
        'wallet_id',
        'deposit_id',
        'amount'
    ];

    /**
     * User model transaction belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Wallet model transaction belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function wallet()
    {
        return $this->belongsTo(Wallet::class, 'wallet_id', 'id');
    }

    /**
     * Deposit model transaction belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function deposit()
    {
        return $this->belongsTo(Deposit::class, 'deposit_id', 'id');
    }

}
