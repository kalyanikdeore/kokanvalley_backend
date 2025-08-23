<?php

namespace App\Filament\Resources\GuestExperienceResource\Pages;

use App\Filament\Resources\GuestExperienceResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGuestExperience extends EditRecord
{
    protected static string $resource = GuestExperienceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
