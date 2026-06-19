<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Klaster;
use Illuminate\Auth\Access\HandlesAuthorization;

class KlasterPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Klaster');
    }

    public function view(AuthUser $authUser, Klaster $klaster): bool
    {
        return $authUser->can('View:Klaster');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Klaster');
    }

    public function update(AuthUser $authUser, Klaster $klaster): bool
    {
        return $authUser->can('Update:Klaster');
    }

    public function delete(AuthUser $authUser, Klaster $klaster): bool
    {
        return $authUser->can('Delete:Klaster');
    }

    public function restore(AuthUser $authUser, Klaster $klaster): bool
    {
        return $authUser->can('Restore:Klaster');
    }

    public function forceDelete(AuthUser $authUser, Klaster $klaster): bool
    {
        return $authUser->can('ForceDelete:Klaster');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Klaster');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Klaster');
    }

    public function replicate(AuthUser $authUser, Klaster $klaster): bool
    {
        return $authUser->can('Replicate:Klaster');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Klaster');
    }

}