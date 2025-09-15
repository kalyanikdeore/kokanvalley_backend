<?php

namespace App\Filament\Resources\ProjectLocationResource\Pages;

use App\Filament\Resources\ProjectLocationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProjectLocations extends ListRecords
{
    protected static string $resource = ProjectLocationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
