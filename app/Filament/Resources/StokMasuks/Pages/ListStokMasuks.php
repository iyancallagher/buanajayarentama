<?php

namespace App\Filament\Resources\StokMasuks\Pages;

use App\Filament\Resources\StokMasuks\StokMasukResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListStokMasuks extends ListRecords
{
    protected static string $resource = StokMasukResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
