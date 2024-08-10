<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Training;

class TrainingPolicy
{
    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Training $training): bool
    {
        return $user->isAdmin();
    }

    public function create(User $user): bool
    {
       return $user->isAdmin();
    }

    public function update(User $user, Training $training): bool
    {
       return $user->isAdmin();
    }

    public function delete(User $user, Training $training): bool
    {
        return $user->isAdmin();
    }
    public function restore(User $user, Training $training): bool
    {
        return $user->isAdmin();
    }
    public function forceDelete(User $user, Training $training): bool
    {
        return $user->isAdmin();
    }
    public function deleteAny(User $user): bool
    {
        return $user->isAdmin();
    }
    public function restoreAny(User $user): bool
    {
        return $user->isAdmin();
    }
    public function forDeleteAny(User $user): bool
    {
        return $user->isAdmin();
    }
}
