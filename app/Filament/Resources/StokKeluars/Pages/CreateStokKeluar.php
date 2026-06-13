<?php

namespace App\Filament\Resources\StokKeluars\Pages;

use App\Filament\Resources\StokKeluars\StokKeluarResource;
use Filament\Resources\Pages\CreateRecord;

class CreateStokKeluar extends CreateRecord
{
    protected static string $resource = StokKeluarResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
