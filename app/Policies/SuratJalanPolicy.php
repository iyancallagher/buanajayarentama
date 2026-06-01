<?php

namespace App\Policies;

use App\Models\SuratJalan;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SuratJalanPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole('super admin', 'admin', 'manager', 'kepala gudang','workshop');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, SuratJalan $suratJalan): bool
    {
        return $user->hasAnyRole('super admin', 'admin', 'manager', 'kepala gudang','workshop');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyRole('super admin');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, SuratJalan $suratJalan): bool
    {
        return $user->hasAnyRole('super admin');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SuratJalan $suratJalan): bool
    {
        return $user->hasAnyRole('super admin');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, SuratJalan $suratJalan): bool
    {
        return $user->hasAnyRole('super admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, SuratJalan $suratJalan): bool
    {
        return $user->hasAnyRole('super admin');
    }
}
