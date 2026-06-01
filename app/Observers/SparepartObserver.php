<?php

namespace App\Observers;

use App\Models\Sparepart;

class SparepartObserver
{
    /**
     * Handle the Sparepart "created" event.
     */
    public function creating(Sparepart $sparepart): void
    {
        // Kode komponen
        $kodeKomponen = strtoupper(
            substr(
                str_replace(' ', '', $sparepart->komponen->nama_komponen),
                0,
                3
            )
        );

        // Kode sparepart
        $kodeSparepart = strtoupper(
            substr(
                str_replace(' ', '', $sparepart->nama_sparepart),
                0,
                3
            )
        );

        // Prefix
        $prefix = $kodeKomponen . '-' . $kodeSparepart . '-';

        // Cari data terakhir
        $lastSparepart = Sparepart::where(
            'kode_sparepart',
            'like',
            $prefix . '%'
        )->latest()
            ->first();

        // Nomor urut
        if ($lastSparepart) {

            $lastNumber = (int) substr(
                $lastSparepart->kode_sparepart,
                -3
            );

            $newNumber = $lastNumber + 1;
        } else {

            $newNumber = 1;
        }

        // Generate final code
        $sparepart->kode_sparepart =
            $prefix .
            str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }

    public function created(Sparepart $sparepart): void
    {
        //
    }

    /**
     * Handle the Sparepart "updated" event.
     */
    public function updated(Sparepart $sparepart): void
    {
        //
    }

    /**
     * Handle the Sparepart "deleted" event.
     */
    public function deleted(Sparepart $sparepart): void
    {
        //
    }

    /**
     * Handle the Sparepart "restored" event.
     */
    public function restored(Sparepart $sparepart): void
    {
        //
    }

    /**
     * Handle the Sparepart "force deleted" event.
     */
    public function forceDeleted(Sparepart $sparepart): void
    {
        //
    }
}
