<?php

namespace App\Filament\Resources\SuratJalans\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class SuratJalanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nomor_surat')
                    ->required(),
                DatePicker::make('tanggal')
                    ->required(),
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('admin_id')
                    ->required()
                    ->numeric(),
                TextInput::make('status')
                    ->required()
                    ->default('draft'),
                Textarea::make('keterangan')
                    ->columnSpanFull(),
            ]);
    }
}
