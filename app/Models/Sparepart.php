<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Sparepart extends Model
{
    use SoftDeletes;
    protected $table = 'spareparts';
    protected $fillable = [
        'nama_sparepart',
        'kode_sparepart',
        'komponen_id',
        'jenis_unit',
        'number_part',
    ];

    public function komponen()
    {
        return $this->belongsTo(Komponen::class);
    }

    protected function jenisUnit(): Attribute
    {
        return Attribute::make(
            get: fn($value) => blank($value)
                ? []
                : collect(explode('/', $value))
                ->map(fn($item) => [
                    'value' => trim($item),
                ])
                ->toArray(),

            set: fn($value) => is_array($value)
                ? collect($value)
                ->pluck('value')
                ->implode('/')
                : $value,
        );
    }
    
    protected function numberPart(): Attribute
    {
        return Attribute::make(
            get: fn($value) => blank($value)
                ? []
                : collect(explode('/', $value))
                ->map(fn($item) => [
                    'value' => trim($item),
                ])
                ->toArray(),

            set: fn($value) => is_array($value)
                ? collect($value)
                ->pluck('value')
                ->implode('/')
                : $value,
        );
    }
    public function stokKeluars()
{
    return $this->hasMany(StokKeluar::class);
}
}
