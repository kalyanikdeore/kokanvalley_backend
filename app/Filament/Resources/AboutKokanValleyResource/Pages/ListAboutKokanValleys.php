<?php

namespace App\Filament\Resources\AboutKokanValleyResource\Pages;

use App\Filament\Resources\AboutKokanValleyResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAboutKokanValleys extends ListRecords
{
    protected static string $resource = AboutKokanValleyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
