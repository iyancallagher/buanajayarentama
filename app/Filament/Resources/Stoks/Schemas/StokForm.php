<?php

namespace App\Filament\Resources\Stoks\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class StokForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('sparepart_id')
                    ->required()
                    ->numeric()
                    ->disabled(),
                TextInput::make('stok')
                    ->required()
                    ->numeric()
                    ->default(0),
                TextInput::make('stok_minimum')
                    ->required()
                    ->numeric()
                    ->default(5),
            ]);
    }
}
