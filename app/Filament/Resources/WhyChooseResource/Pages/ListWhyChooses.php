<?php

namespace App\Filament\Resources\WhyChooseResource\Pages;

use App\Filament\Resources\WhyChooseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListWhyChooses extends ListRecords
{
    protected static string $resource = WhyChooseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
