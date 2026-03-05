<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'cake_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'status',
    ];

    public function cake(): BelongsTo
    {
        return $this->belongsTo(Cake::class);
    }
}
