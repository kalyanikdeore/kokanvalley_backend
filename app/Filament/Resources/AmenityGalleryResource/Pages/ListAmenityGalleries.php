<?php

namespace App\Filament\Resources\AmenityGalleryResource\Pages;

use App\Filament\Resources\AmenityGalleryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAmenityGalleries extends ListRecords
{
    protected static string $resource = AmenityGalleryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
