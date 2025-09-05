<?php

namespace App\Filament\Resources\KonkanGalleryCategoryResource\Pages;

use App\Filament\Resources\KonkanGalleryCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListKonkanGalleryCategories extends ListRecords
{
    protected static string $resource = KonkanGalleryCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
