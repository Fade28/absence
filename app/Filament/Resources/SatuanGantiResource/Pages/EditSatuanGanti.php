<?php

namespace App\Filament\Resources\SatuanGantiResource\Pages;

use App\Filament\Resources\SatuanGantiResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSatuanGanti extends EditRecord
{
    protected static string $resource = SatuanGantiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
