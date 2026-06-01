<?php

namespace App\Filament\Resources\PengajuanSpareparts\Pages;

use App\Filament\Resources\PengajuanSpareparts\PengajuanSparepartResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreatePengajuanSparepart extends CreateRecord
{
    protected static string $resource = PengajuanSparepartResource::class;
    protected function mutateFormDataBeforeCreate(
        array $data
    ): array {

        $data['user_id'] = Auth::id();

        return $data;
    }
}
