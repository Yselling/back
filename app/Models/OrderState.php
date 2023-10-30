<?php

namespace App\Models;

use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderState extends Model
{
    use HasFactory;

    protected $fillable = [
        "state",
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
