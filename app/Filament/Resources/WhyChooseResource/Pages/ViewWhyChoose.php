<?php

namespace App\Filament\Resources\WhyChooseResource\Pages;

use App\Filament\Resources\WhyChooseResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewWhyChoose extends ViewRecord
{
    protected static string $resource = WhyChooseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
