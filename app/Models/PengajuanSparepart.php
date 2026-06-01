<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PengajuanSparepart extends Model
{
    use SoftDeletes;

    protected $table = 'pengajuan_spareparts';

    protected $fillable = [
        'user_id',
        'sparepart_id',
        'requested_quantity',
        'approved_quantity',
        'status',
        'keterangan',
        'foto',
        'approved_by',
        'approved_at',
        'surat_jalan_id'
    ];

    protected $casts = [
        'foto' => 'array',
        'approved_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIP
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function sparepart()
    {
        return $this->belongsTo(Sparepart::class);
    }

    public function approver()
    {
        return $this->belongsTo(
            User::class,
            'approved_by'
        );
    }
    public function suratJalanDetails()
    {
        return $this->hasMany(
            SuratJalanDetail::class,
            'pengajuan_sparepart_id'
        );
    }
    public function suratJalan()
    {
        return $this->belongsTo(
            SuratJalan::class
        );
    }
}
