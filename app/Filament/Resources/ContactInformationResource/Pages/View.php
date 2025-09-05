<?php

namespace App\Filament\Resources\ContactInformationResource\Pages;

use App\Filament\Resources\ContactInformationResource;
use App\Models\ContactInformation;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewContactInformation extends ViewRecord
{
    protected static string $resource = ContactInformationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // Ensure addresses array has proper structure for display
        if (isset($data['addresses']) && is_array($data['addresses'])) {
            foreach ($data['addresses'] as $index => $address) {
                if (!isset($address['line1_en'])) $data['addresses'][$index]['line1_en'] = '';
                if (!isset($address['line1_mr'])) $data['addresses'][$index]['line1_mr'] = '';
                if (!isset($address['line2_en'])) $data['addresses'][$index]['line2_en'] = '';
                if (!isset($address['line2_mr'])) $data['addresses'][$index]['line2_mr'] = '';
            }
        }

        // Ensure social_links array has proper structure for display
        if (isset($data['social_links']) && is_array($data['social_links'])) {
            if (!isset($data['social_links']['facebook'])) $data['social_links']['facebook'] = '';
            if (!isset($data['social_links']['instagram'])) $data['social_links']['instagram'] = '';
            if (!isset($data['social_links']['twitter'])) $data['social_links']['twitter'] = '';
        }

        return $data;
    }
}