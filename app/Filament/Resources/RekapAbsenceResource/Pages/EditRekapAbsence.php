<?php

namespace App\Filament\Resources\RekapAbsenceResource\Pages;

use App\Filament\Resources\RekapAbsenceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRekapAbsence extends EditRecord
{
    protected static string $resource = RekapAbsenceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
