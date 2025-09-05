<?php

namespace App\Filament\Resources\ProjectHighlightResource\Pages;

use App\Filament\Resources\ProjectHighlightResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProjectHighlights extends ListRecords
{
    protected static string $resource = ProjectHighlightResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
