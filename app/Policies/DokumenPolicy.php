<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Dokumen;
use Illuminate\Auth\Access\HandlesAuthorization;

class DokumenPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Dokumen');
    }

    public function view(AuthUser $authUser, Dokumen $dokumen): bool
    {
        return $authUser->can('View:Dokumen');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Dokumen');
    }

    public function update(AuthUser $authUser, Dokumen $dokumen): bool
    {
        return $authUser->can('Update:Dokumen');
    }

    public function delete(AuthUser $authUser, Dokumen $dokumen): bool
    {
        return $authUser->can('Delete:Dokumen');
    }

    public function restore(AuthUser $authUser, Dokumen $dokumen): bool
    {
        return $authUser->can('Restore:Dokumen');
    }

    public function forceDelete(AuthUser $authUser, Dokumen $dokumen): bool
    {
        return $authUser->can('ForceDelete:Dokumen');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Dokumen');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Dokumen');
    }

    public function replicate(AuthUser $authUser, Dokumen $dokumen): bool
    {
        return $authUser->can('Replicate:Dokumen');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Dokumen');
    }

}