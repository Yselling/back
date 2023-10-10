<?php

namespace App\Policies;

use App\Models\Media;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MediaPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {

    }

    public function view(User $user, Media $media): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, Media $media): bool
    {
    }

    public function delete(User $user, Media $media): bool
    {
    }

    public function restore(User $user, Media $media): bool
    {
    }

    public function forceDelete(User $user, Media $media): bool
    {
    }
}
