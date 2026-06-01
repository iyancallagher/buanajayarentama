<?php

namespace App\Filament\Resources\StokKeluars\Pages;

use App\Filament\Resources\StokKeluars\StokKeluarResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditStokKeluar extends EditRecord
{
    protected static string $resource = StokKeluarResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
