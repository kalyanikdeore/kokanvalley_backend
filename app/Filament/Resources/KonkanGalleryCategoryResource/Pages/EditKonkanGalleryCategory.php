<?php

namespace App\Filament\Resources\KonkanGalleryCategoryResource\Pages;

use App\Filament\Resources\KonkanGalleryCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKonkanGalleryCategory extends EditRecord
{
    protected static string $resource = KonkanGalleryCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
