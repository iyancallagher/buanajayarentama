<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SuratJalan extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'nomor_surat',
        'tanggal',
        'user_id',
        'admin_id',
        'status',
        'keterangan',
    ];
    protected $casts = [
        'tanggal' => 'date',
    ];

    public function workshop()
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }

    public function admin()
    {
        return $this->belongsTo(
            User::class,
            'admin_id'
        );
    }

    public function details()
    {
        return $this->hasMany(
            SuratJalanDetail::class
        );
    }
    public function pengajuans()
    {
        return $this->hasMany(
            PengajuanSparepart::class
        );
    }
    // public function stokKeluars()
    // {
    //     return $this->hasMany(StokKeluar::class);
    // }
}
