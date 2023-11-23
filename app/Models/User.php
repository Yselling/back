<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Order;
use App\Models\Product;
use Stripe\StripeClient;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'stripe_id',
        'first_name',
        'last_name',
        'email',
        'password',
        'gender_id',
        'role_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function createOrGetStripeCustomer()
    {
        $stripe = new StripeClient(config('stripe.sk'));

        if ($this->stripe_id !== null) {
            return $stripe->customers->retrieve(
                $this->stripe_id,
                ['expand' => []]
            );
        }
        $customer = $stripe->customers->create([
            'name' => $this->first_name . " " . $this->last_name,
            'email' => $this->email
        ]);
        $this->stripe_id = $customer->id;
        $this->save();

        return $customer;
    }

    public function gender(): BelongsTo
    {
        return $this->belongsTo(Gender::class);
    }

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function cart(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'carts', 'user_id', 'product_id')->withPivot('amount');
    }

}
