<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StokMasuk extends Model
{
    use SoftDeletes;
    protected $table = 'stok_masuks';
    protected $fillable = [
        'sparepart_id',
        'quantity',
        'tanggal_masuk',
        'keterangan',
        'user_id'
    ];

    public function sparepart()
    {
        return $this->belongsTo(Sparepart::class);
    }
    public function user()
{
    return $this->belongsTo(User::class);
}
}
