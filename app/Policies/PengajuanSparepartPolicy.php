<?php

namespace App\Policies;

use App\Models\PengajuanSparepart;
use App\Models\User;

class PengajuanSparepartPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['super admin', 'manager', 'kepala gudang', 'admin', 'workshop']);
    }

    public function view(User $user, PengajuanSparepart $pengajuanSparepart): bool
    {
        if ($user->hasAnyRole(['super admin', 'manager', 'kepala gudang', 'admin'])) {
            return true;
        }

        return $user->hasRole('workshop') && $pengajuanSparepart->user_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->hasRole('workshop');
    }

    public function update(User $user, PengajuanSparepart $pengajuanSparepart): bool
    {
        if ($user->hasRole('super admin')) {
            return true;
        }

        return $user->hasRole('workshop') 
            && $pengajuanSparepart->user_id === $user->id 
            && $pengajuanSparepart->status === 'menunggu';
    }

    // --- POLICY UNTUK SATU DATA (RECORD ACTIONS) ---

    public function delete(User $user, PengajuanSparepart $pengajuanSparepart): bool
    {
        return $user->hasRole('super admin') 
            || ($user->hasRole('workshop') && $pengajuanSparepart->user_id === $user->id && $pengajuanSparepart->status === 'menunggu');
    }

    public function restore(User $user, PengajuanSparepart $pengajuanSparepart): bool
    {
        return $user->hasAnyRole(['super admin', 'workshop']);
    }

    public function forceDelete(User $user, PengajuanSparepart $pengajuanSparepart): bool
    {
        return $user->hasRole('super admin');
    }

    // --- POLICY UNTUK MASAL (BULK ACTIONS - WAJIB BAGI FILAMENT) ---

    public function deleteAny(User $user): bool
    {
        // Mengizinkan Super Admin dan Workshop untuk mengakses fitur hapus massal
        return $user->hasAnyRole(['super admin', 'workshop']);
    }

    public function restoreAny(User $user): bool
    {
        return $user->hasAnyRole(['super admin', 'workshop']);
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->hasRole('super admin');
    }

    // --- CUSTOM ACTIONS ---

    public function approve(User $user): bool
    {
        return $user->hasAnyRole(['super admin', 'manager', 'kepala gudang']);
    }

    public function reject(User $user): bool
    {
        return $user->hasAnyRole(['super admin', 'manager', 'kepala gudang']);
    }

    public function createSuratJalan(User $user): bool
    {
        return $user->hasAnyRole(['super admin', 'admin']);
    }
}