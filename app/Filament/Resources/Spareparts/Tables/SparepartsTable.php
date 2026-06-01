<?php

namespace App\Filament\Resources\Spareparts\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class SparepartsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                // Nomor urut
                TextColumn::make('no')
                    ->label('No')
                    ->rowIndex(),

                // Kode Sparepart
                TextColumn::make('kode_sparepart')
                    ->label('Kode')
                    ->searchable()
                    ->sortable(),

                // Sparepart
                TextColumn::make('nama_sparepart')
                    ->label('Sparepart')
                    ->sortable()
                    ->formatStateUsing(function ($state, $record) {

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

                        return $state . ' / ' .
                            ($jenisUnit ?: '') . ' / ' .
                            ($numberPart ?: '-');
                    })
                    ->wrap()
                    ->searchable(
                        query: function ($query, string $search): void {

                            $query
                                ->where(function ($q) use ($search) {

                                    $q->whereRaw("
                    to_tsvector(
                        'simple',
                        coalesce(nama_sparepart,'') || ' ' ||
                        coalesce(jenis_unit,'')
                    )
                    @@ websearch_to_tsquery('simple', ?)
                ", [$search])

                                ->orWhere('number_part', 'ILIKE', "%{$search}%");
                                })

                                ->selectRaw("
                *,
                ts_rank(
                    to_tsvector(
                        'simple',
                        coalesce(nama_sparepart,'') || ' ' ||
                        coalesce(jenis_unit,'')
                    ),
                    websearch_to_tsquery('simple', ?)
                ) as rank
            ", [$search])

                                ->orderByDesc('rank');
                        }
                    ),
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
