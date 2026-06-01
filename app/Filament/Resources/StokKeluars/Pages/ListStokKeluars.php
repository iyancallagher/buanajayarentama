<?php

namespace App\Filament\Resources\StokKeluars\Pages;

use App\Filament\Resources\StokKeluars\StokKeluarResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListStokKeluars extends ListRecords
{
    protected static string $resource = StokKeluarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
