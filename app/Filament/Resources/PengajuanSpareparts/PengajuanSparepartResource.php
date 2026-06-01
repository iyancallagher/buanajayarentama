<?php

namespace App\Filament\Resources\PengajuanSpareparts;

use App\Filament\Resources\PengajuanSpareparts\Pages\CreatePengajuanSparepart;
use App\Filament\Resources\PengajuanSpareparts\Pages\EditPengajuanSparepart;
use App\Filament\Resources\PengajuanSpareparts\Pages\ListPengajuanSpareparts;
use App\Filament\Resources\PengajuanSpareparts\Schemas\PengajuanSparepartForm;
use App\Filament\Resources\PengajuanSpareparts\Tables\PengajuanSparepartsTable;
use App\Models\PengajuanSparepart;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Filament\Facades\Filament;

class PengajuanSparepartResource extends Resource
{
    protected static ?string $model = PengajuanSparepart::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'PengajuanSparepart';

    public static function form(Schema $schema): Schema
    {
        return PengajuanSparepartForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PengajuanSparepartsTable::configure($table);
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
            'index' => ListPengajuanSpareparts::route('/'),
            'create' => CreatePengajuanSparepart::route('/create'),
            'edit' => EditPengajuanSparepart::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        if (
            $user &&
            $user->hasRole('workshop')
        ) {
            $query->where(
                'user_id',
                Auth::id()
            );
        }

        if (
            $user &&
            $user->hasRole('admin')
        ) {

            $query
                ->where('status', 'disetujui')
                ->whereNull('surat_jalan_id');
        }


        return $query;
    }
    public static function getNavigationBadge(): ?string
    {
        /** @var \App\Models\User|null $user */
        $user = Filament::auth()->user();

        if (! $user) {
            return null;
        }

        if ($user->hasRole('admin')) {
            return (string) PengajuanSparepart::where('status', 'disetujui')
                ->whereNull('surat_jalan_id')
                ->count();
        }
        if ($user->hasRole('manager')) {
            return (string) PengajuanSparepart::where('status', 'menunggu')
                ->count();
        }
        if ($user->hasRole('kepala gudang')) {
            return (string) PengajuanSparepart::where('status', 'menunggu')
                ->count();
        }

        return null;
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'primary';
    }
}
