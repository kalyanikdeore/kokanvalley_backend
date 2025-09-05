<?php

namespace App\Filament\Resources\KonkanValleyGalleryImageResource\Widgets;

use App\Models\KonkanGalleryImage;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class GalleryStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Images', KonkanGalleryImage::count())
                ->icon('heroicon-o-photo')
                ->description('All gallery images')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),
            
            Stat::make('Active Images', KonkanGalleryImage::where('is_active', true)->count())
                ->icon('heroicon-o-check-circle')
                ->description('Currently visible images')
                ->color('primary'),
                
            Stat::make('Inactive Images', KonkanGalleryImage::where('is_active', false)->count())
                ->icon('heroicon-o-x-circle')
                ->description('Hidden from gallery')
                ->color('danger'),
        ];
    }
}