<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function orderSituation(): BelongsTo
    {
        return $this->belongsTo(OrderSituation::class);
    }

    public function orderFlow(): BelongsTo
    {
        return $this->belongsTo(OrderFlow::class);
    }

    public function orderFlows(): HasMany
    {
        return $this->hasMany(OrderFlow::class)->orderBy('created_at', 'DESC');
    }

    public function assigned(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_id');
    }

    public function registered(): BelongsTo
    {
        return $this->belongsTo(User::class, 'registered_id');
    }
}
