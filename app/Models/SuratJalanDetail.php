<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SuratJalanDetail extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'surat_jalan_id',
        'pengajuan_sparepart_id',
        'sparepart_id',
        'quantity',
    ];
    
    public function suratJalan()
    {
        return $this->belongsTo(
            SuratJalan::class
        );
    }

    public function pengajuan()
    {
        return $this->belongsTo(
            PengajuanSparepart::class,
            'pengajuan_sparepart_id'
        );
    }

    public function sparepart()
    {
        return $this->belongsTo(
            Sparepart::class
        );
    }
}
