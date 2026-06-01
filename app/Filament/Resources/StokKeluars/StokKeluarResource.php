<?php

namespace App\Filament\Resources\StokKeluars;

use App\Filament\Resources\StokKeluars\Pages\CreateStokKeluar;
use App\Filament\Resources\StokKeluars\Pages\EditStokKeluar;
use App\Filament\Resources\StokKeluars\Pages\ListStokKeluars;
use App\Filament\Resources\StokKeluars\Schemas\StokKeluarForm;
use App\Filament\Resources\StokKeluars\Tables\StokKeluarsTable;
use App\Models\StokKeluar;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class StokKeluarResource extends Resource
{
    protected static ?string $model = StokKeluar::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'StokKeluar';

    public static function form(Schema $schema): Schema
    {
        return StokKeluarForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StokKeluarsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListStokKeluars::route('/'),
            'create' => CreateStokKeluar::route('/create'),
            'edit' => EditStokKeluar::route('/{record}/edit'),
        ];
    }
}
