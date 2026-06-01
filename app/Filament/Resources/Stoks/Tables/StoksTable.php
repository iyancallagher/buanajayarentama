<?php

namespace App\Filament\Resources\Stoks\Tables;

use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;

class StoksTable
{
    public static function configure(
        Table $table
    ): Table {

        return $table

            ->striped()

            ->recordClasses(
                fn() => 'hover:bg-gray-50 transition'
            )

            ->columns([

                TextColumn::make('no')
                    ->label('No')
                    ->rowIndex()
                    ->badge()
                    ->color('gray'),

                TextColumn::make('sparepart.kode_sparepart')
                    ->label('Kode')
                    ->icon('heroicon-o-qr-code')
                    ->iconColor('primary')
                    ->badge()
                    ->searchable(),

                TextColumn::make('sparepart.nama_sparepart')
                    ->label('Sparepart')
                    ->icon('heroicon-o-wrench-screwdriver')
                    ->iconColor('gray')
                    ->searchable()
                    ->formatStateUsing(function (
                        $state,
                        $record
                    ) {
                        $jenisUnit = is_array(
                            $record->sparepart->jenis_unit
                        )
                            ? collect(
                                $record->sparepart->jenis_unit
                            )
                            ->pluck('value')
                            ->implode(' / ')
                            : $record->sparepart->jenis_unit;

                        $numberPart = is_array(
                            $record->sparepart->number_part
                        )
                            ? collect(
                                $record->sparepart->number_part
                            )
                            ->pluck('value')
                            ->implode(' / ')
                            : $record->sparepart->number_part;

                        return
                            $record->sparepart->nama_sparepart .
                            ' / ' .
                            ($jenisUnit ?: '-') .
                            ' / ' .
                            ($numberPart ?: '-');
                    })

                    ->wrap(),

                TextColumn::make('stok')
                    ->label('Stok')
                    ->badge()
                    ->sortable()
                    ->icon(
                        fn($state, $record) =>
                        $state <= $record->stok_minimum
                            ? 'heroicon-o-exclamation-triangle'
                            : 'heroicon-o-check-circle'
                    )
                    ->color(
                        fn($state, $record) =>
                        $state <= $record->stok_minimum
                            ? 'danger'
                            : 'success'
                    ),

                TextColumn::make('stok_minimum')
                    ->label('Min Stok')
                    ->badge()
                    ->icon('heroicon-o-shield-exclamation')
                    ->color('warning'),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->since()
                    ->icon('heroicon-o-calendar-days')
                    ->iconColor('gray')
                    ->sortable()
                    ->toggleable(
                        isToggledHiddenByDefault: true
                    ),

                TextColumn::make('updated_at')
                    ->label('Diupdate')
                    ->since()
                    ->icon('heroicon-o-clock')
                    ->iconColor('gray')
                    ->sortable()
                    ->toggleable(
                        isToggledHiddenByDefault: true
                    ),
            ])

            ->filters([
                TrashedFilter::make(),
            ])

            ->recordActions([

                EditAction::make()
                    ->label('Edit')
                    ->icon('heroicon-o-pencil-square')
                    ->color('warning'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ])
                    ->visible(
                        auth()->user()?->hasAnyRole([
                            'manager',
                            'kepala gudang',
                        ])
                    ),
            ]);
    }
}
