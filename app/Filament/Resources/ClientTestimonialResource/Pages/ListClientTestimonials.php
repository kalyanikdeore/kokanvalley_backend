<?php

namespace App\Filament\Resources\ClientTestimonialResource\Pages;

use App\Filament\Resources\ClientTestimonialResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListClientTestimonials extends ListRecords
{
    protected static string $resource = ClientTestimonialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
