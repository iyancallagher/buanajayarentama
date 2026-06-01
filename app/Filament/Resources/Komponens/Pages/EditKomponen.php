<?php

namespace App\Filament\Resources\Komponens\Pages;

use App\Filament\Resources\Komponens\KomponenResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditKomponen extends EditRecord
{
    protected static string $resource = KomponenResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
