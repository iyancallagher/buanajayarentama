<?php

namespace App\Observers;

use App\Models\SuratJalan;
use Illuminate\Support\Facades\DB;
use Exception;

class SuratJalanObserver
{
    /**
     * Handle the SuratJalan "created" event.
     */
    public function created(SuratJalan $suratJalan): void
    {
        //
    }

    /**
     * Handle the SuratJalan "updated" event.
     */
public function updated(SuratJalan $suratJalan): void
    {
        if (
            $suratJalan->wasChanged('status') &&
            $suratJalan->status === 'dikirim'
        ) {
            DB::transaction(function () use ($suratJalan) {
                $suratJalan->load('details');
                foreach ($suratJalan->details as $detail) {
                    $stok = \App\Models\Stok::where(
                        'sparepart_id',
                        $detail->sparepart_id
                    )->first();
                    if (! $stok) {
                        throw new Exception(
                            "Data stok sparepart tidak ditemukan."
                        );
                    }
                    if ($stok->stok < $detail->quantity) {
                        throw new Exception(
                            "Stok tidak mencukupi."
                        );
                    }
                    $stok->decrement(
                        'stok',
                        $detail->quantity
                    );
                }
            });
        }
    }

    /**
     * Handle the SuratJalan "deleted" event.
     */
    public function deleted(SuratJalan $suratJalan): void
    {
        //
    }

    /**
     * Handle the SuratJalan "restored" event.
     */
    public function restored(SuratJalan $suratJalan): void
    {
        //
    }

    /**
     * Handle the SuratJalan "force deleted" event.
     */
    public function forceDeleted(SuratJalan $suratJalan): void
    {
        //
    }
}
