<?php

namespace App\Filament\Resources\StokMasuks\Pages;

use App\Filament\Resources\StokMasuks\StokMasukResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;

class CreateStokMasuk extends CreateRecord
{
    protected static string $resource = StokMasukResource::class;
    protected function mutateFormDataBeforeCreate(array $data): array
{
    $data['user_id'] = Auth::id();
    return $data;
}
}
