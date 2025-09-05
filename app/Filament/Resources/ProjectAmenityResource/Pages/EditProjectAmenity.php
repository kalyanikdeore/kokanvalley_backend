<?php

namespace App\Filament\Resources\ProjectAmenityResource\Pages;

use App\Filament\Resources\ProjectAmenityResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProjectAmenity extends EditRecord
{
    protected static string $resource = ProjectAmenityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
