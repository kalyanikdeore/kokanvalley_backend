<?php

namespace App\Filament\Resources\AboutKokanValleyResource\Pages;

use App\Filament\Resources\AboutKokanValleyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAboutKokanValley extends EditRecord
{
    protected static string $resource = AboutKokanValleyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
