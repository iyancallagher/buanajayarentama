<?php

namespace App\Filament\Resources\StokMasuks\Schemas;

use Filament\Schemas\Schema;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;


class StokMasukForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('sparepart_id')
                    ->label('Sparepart')

                    ->relationship(
                        'sparepart',
                        'nama_sparepart',
                        modifyQueryUsing: fn($query) =>
                        $query->select([
                            'id',
                            'nama_sparepart',
                            'jenis_unit',
                            'number_part',
                        ])
                    )
                    ->getOptionLabelFromRecordUsing(function ($record) {
                        $jenisUnit = is_array($record->jenis_unit)
                            ? collect($record->jenis_unit)
                            ->pluck('value')
                            ->implode(' / ')
                            : $record->jenis_unit;

                        $numberPart = is_array($record->number_part)
                            ? collect($record->number_part)
                            ->pluck('value')
                            ->implode(' / ')
                            : $record->number_part;

                        return $record->nama_sparepart . ' / ' .
                            ($jenisUnit ?: '-') . ' / ' .
                            ($numberPart ?: '-');
                    })
                    ->searchable([
                        'nama_sparepart',
                        'jenis_unit',
                        'number_part',
                        'kode_sparepart',
                    ])
                    ->preload()
                    ->required(),
                TextInput::make('quantity')
                    ->label('Jumlah Masuk')
                    ->numeric()
                    ->default(1)
                    ->minValue(1)
                    ->required(),
                DatePicker::make('tanggal_masuk')
                    ->label('Tanggal Masuk')
                    ->default(now())
                    ->required(),
                Textarea::make('keterangan')
                    ->label('Keterangan')
                    ->rows(4)
                    ->placeholder('Masukkan keterangan tambahan...')
                    ->columnSpanFull(),
            ]);
    }
}
