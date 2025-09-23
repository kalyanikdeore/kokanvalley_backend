<?php

namespace App\Filament\Resources\AmenitiesSectionResource\Pages;

use App\Filament\Resources\AmenitiesSectionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAmenitiesSections extends ListRecords
{
    protected static string $resource = AmenitiesSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
