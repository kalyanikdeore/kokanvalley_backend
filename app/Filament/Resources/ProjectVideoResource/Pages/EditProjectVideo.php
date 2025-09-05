<?php

namespace App\Filament\Resources\ProjectVideoResource\Pages;

use App\Filament\Resources\ProjectVideoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProjectVideo extends EditRecord
{
    protected static string $resource = ProjectVideoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
