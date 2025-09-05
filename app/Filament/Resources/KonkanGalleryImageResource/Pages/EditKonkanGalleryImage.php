<?php

namespace App\Filament\Resources\KonkanGalleryImageResource\Pages;

use App\Filament\Resources\KonkanGalleryImageResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKonkanGalleryImage extends EditRecord
{
    protected static string $resource = KonkanGalleryImageResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
