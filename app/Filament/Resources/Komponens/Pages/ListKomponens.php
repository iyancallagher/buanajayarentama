<?php

namespace App\Filament\Resources\Komponens\Pages;

use App\Filament\Resources\Komponens\KomponenResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListKomponens extends ListRecords
{
    protected static string $resource = KomponenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
