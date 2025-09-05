<?php

namespace App\Filament\Resources\ProjectProductResource\Pages;

use App\Filament\Resources\ProjectProductResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProjectProducts extends ListRecords
{
    protected static string $resource = ProjectProductResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
