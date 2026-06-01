<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StokKeluar extends Model
{
    protected $fillable = [
        'surat_jalan_id',
        'sparepart_id',
        'quantity',
    ];

    public function suratJalan()
    {
        return $this->belongsTo(SuratJalan::class);
    }

    public function sparepart()
    {
        return $this->belongsTo(Sparepart::class);
    }
}