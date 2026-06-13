<?php

namespace App\Filament\Resources\Komponens;

use App\Filament\Resources\Komponens\Pages\CreateKomponen;
use App\Filament\Resources\Komponens\Pages\EditKomponen;
use App\Filament\Resources\Komponens\Pages\ListKomponens;
use App\Filament\Resources\Komponens\Schemas\KomponenForm;
use App\Filament\Resources\Komponens\Tables\KomponensTable;
use App\Models\Komponen;
use BackedEnum;
use UnitEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class KomponenResource extends Resource
{
    protected static ?string $model = Komponen::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTag;

    protected static string | UnitEnum | null $navigationGroup = 'Master Data';

    protected static ?string $recordTitleAttribute = 'Komponen';

    public static function form(Schema $schema): Schema
    {
        return KomponenForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return KomponensTable::configure($table);
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
            'index' => ListKomponens::route('/'),
            'create' => CreateKomponen::route('/create'),
            'edit' => EditKomponen::route('/{record}/edit'),
        ];
    }
}
