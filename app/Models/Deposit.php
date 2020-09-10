<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Deposit extends Model
{
    use HasFactory, SoftDeletes;

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
        'is_active',
        'duration',
        'accrue_times'
    ];
    
    protected $casts = [
        'is_active' => 'boolean',
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
