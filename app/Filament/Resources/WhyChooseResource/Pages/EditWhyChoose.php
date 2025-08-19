<?php

namespace App\Filament\Resources\WhyChooseResource\Pages;

use App\Filament\Resources\WhyChooseResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditWhyChoose extends EditRecord
{
    protected static string $resource = WhyChooseResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
