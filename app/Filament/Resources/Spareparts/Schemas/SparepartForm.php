<?php

namespace App\Filament\Resources\Spareparts\Schemas;

use Filament\Schemas\Schema;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Repeater;

class SparepartForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([

                TextInput::make('nama_sparepart')
                    ->label('Nama Sparepart')
                    ->required()
                    ->maxLength(255),
                Select::make('komponen_id')
                    ->label('Komponen')
                    ->relationship('komponen', 'nama_komponen')
                    ->searchable()
                    ->preload()
                    ->required(),

                Repeater::make('jenis_unit')
                    ->schema([
                        TextInput::make('value')
                            ->required(),
                    ]),

                Repeater::make('number_part')
                    ->schema([
                        TextInput::make('value')
                            ->required(),
                    ])
            ]);
    }
}
