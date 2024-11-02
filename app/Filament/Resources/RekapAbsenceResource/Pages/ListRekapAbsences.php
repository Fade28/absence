<?php

namespace App\Filament\Resources\RekapAbsenceResource\Pages;

use App\Filament\Resources\RekapAbsenceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRekapAbsences extends ListRecords
{
    protected static string $resource = RekapAbsenceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
