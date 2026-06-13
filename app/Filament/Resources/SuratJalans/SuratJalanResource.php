<?php

namespace App\Filament\Resources\SuratJalans;

use App\Filament\Resources\SuratJalans\Pages\CreateSuratJalan;
use App\Filament\Resources\SuratJalans\Pages\EditSuratJalan;
use App\Filament\Resources\SuratJalans\Pages\ListSuratJalans;
use App\Filament\Resources\SuratJalans\Schemas\SuratJalanForm;
use App\Filament\Resources\SuratJalans\Tables\SuratJalansTable;
use App\Models\SuratJalan;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SuratJalanResource extends Resource
{
    protected static ?string $model = SuratJalan::class;
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedClipboardDocumentList;
    protected static string | UnitEnum | null $navigationGroup = 'Transaksi Barang';
    protected static ?string $recordTitleAttribute = 'SuratJalan';
    public static function form(Schema $schema): Schema
    {
        return SuratJalanForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SuratJalansTable::configure($table);
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
            'index' => ListSuratJalans::route('/'),
            'create' => CreateSuratJalan::route('/create'),
            'edit' => EditSuratJalan::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
    public static function canCreate(): bool
    {
        return false;
    }
}
