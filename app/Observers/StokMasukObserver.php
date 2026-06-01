<?php

namespace App\Observers;

use App\Models\StokMasuk;
use App\Models\Stok;

class StokMasukObserver
{
    public function created(StokMasuk $stokMasuk): void
    {
        // Cari stok sparepart
        $stok = Stok::where(
            'sparepart_id',
            $stokMasuk->sparepart_id
        )->first();

        // Kalau belum ada → create stok
        if (!$stok) {

            $stok = Stok::create([
                'sparepart_id' => $stokMasuk->sparepart_id,
                'stok' => 0,
                'stok_minimum' => 5,
            ]);
        }

        // Tambah stok
        $stok->increment(
            'stok',
            $stokMasuk->quantity
        );
    }


    /**
     * Handle the StokMasuk "updated" event.
     */
    public function updated(StokMasuk $stokMasuk): void
    {
        //
    }

    /**
     * Handle the StokMasuk "deleted" event.
     */
    public function deleted(StokMasuk $stokMasuk): void
    {
        //
    }

    /**
     * Handle the StokMasuk "restored" event.
     */
    public function restored(StokMasuk $stokMasuk): void
    {
        //
    }

    /**
     * Handle the StokMasuk "force deleted" event.
     */
    public function forceDeleted(StokMasuk $stokMasuk): void
    {
        //
    }
}
