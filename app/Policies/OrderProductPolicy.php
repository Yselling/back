<?php

namespace App\Policies;

use App\Models\OrderProduct;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderProductPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {

    }

    public function view(User $user, OrderProduct $orderProduct): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, OrderProduct $orderProduct): bool
    {
    }

    public function delete(User $user, OrderProduct $orderProduct): bool
    {
    }

    public function restore(User $user, OrderProduct $orderProduct): bool
    {
    }

    public function forceDelete(User $user, OrderProduct $orderProduct): bool
    {
    }
}
