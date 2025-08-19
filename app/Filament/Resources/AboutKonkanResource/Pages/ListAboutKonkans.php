<?php

namespace App\Filament\Resources\AboutKonkanResource\Pages;

use App\Filament\Resources\AboutKonkanResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAboutKonkans extends ListRecords
{
    protected static string $resource = AboutKonkanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
