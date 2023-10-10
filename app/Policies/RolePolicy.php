<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {

    }

    public function view(User $user, Role $role): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, Role $role): bool
    {
    }

    public function delete(User $user, Role $role): bool
    {
    }

    public function restore(User $user, Role $role): bool
    {
    }

    public function forceDelete(User $user, Role $role): bool
    {
    }
}
