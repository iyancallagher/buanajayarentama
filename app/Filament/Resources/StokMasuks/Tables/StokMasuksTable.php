<?php

namespace App\Filament\Resources\StokMasuks\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class StokMasuksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                // Nomor
                TextColumn::make('no')
                    ->label('No')
                    ->rowIndex(),

                // Sparepart
                TextColumn::make('sparepart.nama_sparepart')
                    ->label('Sparepart')
                    ->formatStateUsing(function ($state, $record) {
                        $jenisUnit = is_array($record->sparepart->jenis_unit)
                            ? collect($record->sparepart->jenis_unit)
                                ->pluck('value')
                                ->implode(' / ')
                            : $record->sparepart->jenis_unit;
                        $numberPart = is_array($record->sparepart->number_part)
                            ? collect($record->sparepart->number_part)
                                ->pluck('value')
                                ->implode(' / ')
                            : $record->sparepart->number_part;
                        return $record->sparepart->nama_sparepart . ' / ' .
                            ($jenisUnit ?: '-') . ' / ' .
                            ($numberPart ?: '-');
                    })
                    ->searchable()
                    ->wrap(),

                // Quantity
                TextColumn::make('quantity')
                    ->label('Quantity')
                    ->badge()
                    ->color('success')
                    ->sortable(),

                // Tanggal Masuk
                TextColumn::make('tanggal_masuk')
                    ->label('Tanggal Masuk')
                    ->date()
                    ->sortable(),

                // Keterangan
                TextColumn::make('keterangan')
                    ->label('Keterangan')
                    ->limit(30)
                    ->default('Tidak Ada Keterangan')
                    ->toggleable(),

                // User Input
                TextColumn::make('user.name')
                    ->label('Diinput Oleh')
                    ->default('User Deleted')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                // Created At
                TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                // Updated At
                TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                // Deleted At
                TextColumn::make('deleted_at')
                    ->label('Deleted')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])

            ->filters([
                TrashedFilter::make(),
            ])

            ->recordActions([
                EditAction::make(),
            ])

            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}