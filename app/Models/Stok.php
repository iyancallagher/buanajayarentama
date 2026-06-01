<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stok extends Model
{
    use SoftDeletes;
    protected $table = 'stoks';
    protected $fillable = [
        'sparepart_id',
        'stok',
        'stok_minimum',
    ];

    public function sparepart()
    {
        return $this->belongsTo(Sparepart::class);
    }
}
