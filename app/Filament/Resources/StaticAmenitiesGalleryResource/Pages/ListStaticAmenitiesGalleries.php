<?php

namespace App\Filament\Resources\StaticAmenitiesGalleryResource\Pages;

use App\Filament\Resources\StaticAmenitiesGalleryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStaticAmenitiesGalleries extends ListRecords
{
    protected static string $resource = StaticAmenitiesGalleryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
