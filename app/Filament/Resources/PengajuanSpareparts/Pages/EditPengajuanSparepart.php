<?php

namespace App\Filament\Resources\PengajuanSpareparts\Pages;

use App\Filament\Resources\PengajuanSpareparts\PengajuanSparepartResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ForceDeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Resources\Pages\EditRecord;

class EditPengajuanSparepart extends EditRecord
{
    protected static string $resource = PengajuanSparepartResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
            ForceDeleteAction::make(),
            RestoreAction::make(),
        ];
    }
}
