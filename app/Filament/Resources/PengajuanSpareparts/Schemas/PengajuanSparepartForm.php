<?php

namespace App\Filament\Resources\PengajuanSpareparts\Schemas;

use Filament\Schemas\Schema;

use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;

class PengajuanSparepartForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Pengajuan Sparepart')
                    ->columnSpanFull()
                    ->schema([
                        Select::make('sparepart_id')
                            ->label('Sparepart')

                            ->relationship(
                                'sparepart',
                                'nama_sparepart'
                            )
                            ->getOptionLabelFromRecordUsing(
                                fn($record) =>

                                $record->nama_sparepart . ' / ' .

                                    (
                                        is_array($record->jenis_unit)
                                        ? collect($record->jenis_unit)
                                        ->pluck('value')
                                        ->implode(' / ')
                                        : ($record->jenis_unit ?? '-')
                                    )

                                    . ' / ' .

                                    (
                                        is_array($record->number_part)
                                        ? collect($record->number_part)
                                        ->pluck('value')
                                        ->implode(' / ')
                                        : ($record->number_part ?? '-')
                                    )
                            )
                            ->searchable()
                            ->preload()
                            ->required(),
                        TextInput::make(
                            'requested_quantity'
                        )
                            ->label('Qty Permintaan')

                            ->numeric()

                            ->nullable(),

                        Textarea::make('keterangan')
                            ->label('Keterangan')
                            ->rows(4)
                            ->nullable(),

                        FileUpload::make('foto')

                            ->label('Foto Kerusakan')

                            ->multiple()

                            ->disk('public')

                            ->visibility('public')

                            ->directory('pengajuan-sparepart')

                            ->image()

                            ->imageEditor()

                            ->imagePreviewHeight('150')

                            ->panelLayout('grid')

                            ->appendFiles()

                            ->reorderable()

                            ->openable()

                            ->downloadable()

                            ->maxFiles(10)

                            ->nullable()
                    ])

                    ->columns(2),
            ]);
    }
}
