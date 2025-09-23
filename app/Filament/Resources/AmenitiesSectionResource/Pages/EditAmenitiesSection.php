<?php

namespace App\Filament\Resources\AmenitiesSectionResource\Pages;

use App\Filament\Resources\AmenitiesSectionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditAmenitiesSection extends EditRecord
{
    protected static string $resource = AmenitiesSectionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
