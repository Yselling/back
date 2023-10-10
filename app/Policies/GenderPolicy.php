<?php

namespace App\Policies;

use App\Models\Gender;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class GenderPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {

    }

    public function view(User $user, Gender $gender): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, Gender $gender): bool
    {
    }

    public function delete(User $user, Gender $gender): bool
    {
    }

    public function restore(User $user, Gender $gender): bool
    {
    }

    public function forceDelete(User $user, Gender $gender): bool
    {
    }
}
