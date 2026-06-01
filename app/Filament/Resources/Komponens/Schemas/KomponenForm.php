<?php

namespace App\Filament\Resources\Komponens\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class KomponenForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nama_komponen')
                    ->required(),
                TextInput::make('kode_komponen')
                    ->disabled()
                    ->dehydrated(false),
            ]);
    }
}
