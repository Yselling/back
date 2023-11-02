<?php

namespace App\Models;

use App\Models\Order;
use Laravel\Scout\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;
    use Searchable;

    public function searchableAs(): string
    {
        return 'products_index';
    }

    public function toSearchableArray()
    {
        $array = [
            'name' => $this->name,
            'description' => $this->description,
            'category_id' => $this->category_id,
        ];

        return $array;
    }



    protected $fillable = [
        "name",
        "description",
        "price",
        "type",
        "quantity",
        "category_id",
        "image"
    ];

    protected $appends = [
        'url',
    ];

    public function getUrlAttribute(): string
    {
        return route('products.show', $this);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function medias(): HasMany
    {
        return $this->hasMany(Media::class);
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class)->withPivot('amount');
    }
}
