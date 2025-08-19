<?php

namespace App\Filament\Resources\VisionMissionResource\Pages;

use App\Filament\Resources\VisionMissionResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewVisionMission extends ViewRecord
{
    protected static string $resource = VisionMissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
