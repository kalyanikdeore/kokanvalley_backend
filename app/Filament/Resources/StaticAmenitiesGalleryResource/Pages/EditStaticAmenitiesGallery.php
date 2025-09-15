<?php

namespace App\Filament\Resources\StaticAmenitiesGalleryResource\Pages;

use App\Filament\Resources\StaticAmenitiesGalleryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStaticAmenitiesGallery extends EditRecord
{
    protected static string $resource = StaticAmenitiesGalleryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
