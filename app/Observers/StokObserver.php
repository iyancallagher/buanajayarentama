<?php

namespace App\Observers;

use App\Models\Stok;

class StokObserver
{
    /**
     * Handle the Stok "created" event.
     */
    public function created(Stok $stok): void
    {
        //
    }

    /**
     * Handle the Stok "updated" event.
     */
    public function updated(Stok $stok): void
    {
        //
    }

    /**
     * Handle the Stok "deleted" event.
     */
    public function deleted(Stok $stok): void
    {
        //
    }

    /**
     * Handle the Stok "restored" event.
     */
    public function restored(Stok $stok): void
    {
        //
    }

    /**
     * Handle the Stok "force deleted" event.
     */
    public function forceDeleted(Stok $stok): void
    {
        //
    }
}
