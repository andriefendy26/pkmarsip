<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Lokasi;
use Illuminate\Auth\Access\HandlesAuthorization;

class LokasiPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Lokasi');
    }

    public function view(AuthUser $authUser, Lokasi $lokasi): bool
    {
        return $authUser->can('View:Lokasi');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Lokasi');
    }

    public function update(AuthUser $authUser, Lokasi $lokasi): bool
    {
        return $authUser->can('Update:Lokasi');
    }

    public function delete(AuthUser $authUser, Lokasi $lokasi): bool
    {
        return $authUser->can('Delete:Lokasi');
    }

    public function restore(AuthUser $authUser, Lokasi $lokasi): bool
    {
        return $authUser->can('Restore:Lokasi');
    }

    public function forceDelete(AuthUser $authUser, Lokasi $lokasi): bool
    {
        return $authUser->can('ForceDelete:Lokasi');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Lokasi');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Lokasi');
    }

    public function replicate(AuthUser $authUser, Lokasi $lokasi): bool
    {
        return $authUser->can('Replicate:Lokasi');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Lokasi');
    }

}