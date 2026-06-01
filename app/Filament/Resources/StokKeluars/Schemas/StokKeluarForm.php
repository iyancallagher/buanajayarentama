<?php

namespace App\Filament\Resources\StokKeluars\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class StokKeluarForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('surat_jalan_id')
                    ->required()
                    ->numeric(),
                TextInput::make('sparepart_id')
                    ->required()
                    ->numeric(),
                TextInput::make('quantity')
                    ->required()
                    ->numeric(),
            ]);
    }
}
