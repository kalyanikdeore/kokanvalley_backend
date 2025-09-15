<?php

namespace App\Filament\Resources\ProjectLocationResource\Pages;

use App\Filament\Resources\ProjectLocationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProjectLocation extends EditRecord
{
    protected static string $resource = ProjectLocationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
