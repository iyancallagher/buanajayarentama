<?php

namespace App\Filament\Resources\Komponens\Pages;

use App\Filament\Resources\Komponens\KomponenResource;
use Filament\Resources\Pages\CreateRecord;

class CreateKomponen extends CreateRecord
{
    protected static string $resource = KomponenResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
