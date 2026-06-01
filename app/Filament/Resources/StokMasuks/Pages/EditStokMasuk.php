<?php

namespace App\Filament\Resources\StokMasuks\Pages;

use App\Filament\Resources\StokMasuks\StokMasukResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditStokMasuk extends EditRecord
{
    protected static string $resource = StokMasukResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
