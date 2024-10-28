<?php

namespace App\Filament\Resources\SatuanGantiResource\Pages;

use App\Filament\Resources\SatuanGantiResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSatuanGantis extends ListRecords
{
    protected static string $resource = SatuanGantiResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
