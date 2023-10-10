<?php

namespace App\Policies;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CartPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {

    }

    public function view(User $user, Cart $cart): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, Cart $cart): bool
    {
    }

    public function delete(User $user, Cart $cart): bool
    {
    }

    public function restore(User $user, Cart $cart): bool
    {
    }

    public function forceDelete(User $user, Cart $cart): bool
    {
    }
}
