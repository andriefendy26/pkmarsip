<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\JenisDokumen;
use Illuminate\Auth\Access\HandlesAuthorization;

class JenisDokumenPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:JenisDokumen');
    }

    public function view(AuthUser $authUser, JenisDokumen $jenisDokumen): bool
    {
        return $authUser->can('View:JenisDokumen');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:JenisDokumen');
    }

    public function update(AuthUser $authUser, JenisDokumen $jenisDokumen): bool
    {
        return $authUser->can('Update:JenisDokumen');
    }

    public function delete(AuthUser $authUser, JenisDokumen $jenisDokumen): bool
    {
        return $authUser->can('Delete:JenisDokumen');
    }

    public function restore(AuthUser $authUser, JenisDokumen $jenisDokumen): bool
    {
        return $authUser->can('Restore:JenisDokumen');
    }

    public function forceDelete(AuthUser $authUser, JenisDokumen $jenisDokumen): bool
    {
        return $authUser->can('ForceDelete:JenisDokumen');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:JenisDokumen');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:JenisDokumen');
    }

    public function replicate(AuthUser $authUser, JenisDokumen $jenisDokumen): bool
    {
        return $authUser->can('Replicate:JenisDokumen');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:JenisDokumen');
    }

}