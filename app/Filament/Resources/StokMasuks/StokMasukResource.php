<?php

namespace App\Filament\Resources\StokMasuks;

use App\Filament\Resources\StokMasuks\Pages\CreateStokMasuk;
use App\Filament\Resources\StokMasuks\Pages\EditStokMasuk;
use App\Filament\Resources\StokMasuks\Pages\ListStokMasuks;
use App\Filament\Resources\StokMasuks\Schemas\StokMasukForm;
use App\Filament\Resources\StokMasuks\Tables\StokMasuksTable;
use App\Models\StokMasuk;
use UnitEnum;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StokMasukResource extends Resource
{
    protected static ?string $model = StokMasuk::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentPlus;
    protected static string | UnitEnum | null $navigationGroup = 'Transaksi Barang';
    protected static ?string $recordTitleAttribute = 'StokMasuk';
    public static function form(Schema $schema): Schema
    {
        return StokMasukForm::configure($schema);
    }
    public static function table(Table $table): Table
    {
        return StokMasuksTable::configure($table);
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
            'index' => ListStokMasuks::route('/'),
            'create' => CreateStokMasuk::route('/create'),
            'edit' => EditStokMasuk::route('/{record}/edit'),
        ];
    }
    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
