<?php

namespace App\Filament\Resources\PengajuanSpareparts\Pages;

use App\Filament\Resources\PengajuanSpareparts\PengajuanSparepartResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPengajuanSpareparts extends ListRecords
{
    protected static string $resource = PengajuanSparepartResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
