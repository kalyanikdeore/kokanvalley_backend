<?php

namespace App\Filament\Resources\GuestExperienceResource\Pages;

use App\Filament\Resources\GuestExperienceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGuestExperiences extends ListRecords
{
    protected static string $resource = GuestExperienceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
