<?php

namespace App\Observers;

use App\Models\Komponen;

class KomponenObserver
{
    /**
     * Handle the Komponen "created" event.
     */
    public function creating(Komponen $komponen): void
    { {
            $komponen->kode_komponen = strtoupper(
                substr(
                    str_replace(' ', '', $komponen->nama_komponen),
                    0,
                    3
                )
            );
        }
    }
    public function created(Komponen $komponen): void
    {
        //
    }

    /**
     * Handle the Komponen "updated" event.
     */
    public function updated(Komponen $komponen): void
    {
        //
    }

    /**
     * Handle the Komponen "deleted" event.
     */
    public function deleted(Komponen $komponen): void
    {
        //
    }

    /**
     * Handle the Komponen "restored" event.
     */
    public function restored(Komponen $komponen): void
    {
        //
    }

    /**
     * Handle the Komponen "force deleted" event.
     */
    public function forceDeleted(Komponen $komponen): void
    {
        //
    }
}
