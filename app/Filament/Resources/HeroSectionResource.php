<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HeroSectionResource\Pages;
use App\Models\HeroSection;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class HeroSectionResource extends Resource
{
    protected static ?string $model = HeroSection::class;

    protected static ?string $navigationIcon = 'heroicon-o-play';

    protected static ?string $navigationGroup = 'Home Page';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title_en')
                    ->required()
                    ->maxLength(255)
                    ->label('Title (English)'),
                Forms\Components\TextInput::make('title_mr')
                    ->required()
                    ->maxLength(255)
                    ->label('Title (Marathi)'),
                Forms\Components\Textarea::make('description_en')
                    ->required()
                    ->label('Description (English)'),
                Forms\Components\Textarea::make('description_mr')
                    ->required()
                    ->label('Description (Marathi)'),
                Forms\Components\FileUpload::make('video_url')
                    ->required()
                    ->disk('public')
                    ->directory('hero-videos')
                    ->acceptedFileTypes(['video/mp4'])
                    ->maxSize(102400) // 100MB
                    ->getUploadedFileNameForStorageUsing(
                        // Use the Livewire TemporaryUploadedFile class
                        fn (TemporaryUploadedFile $file): string => (string) 'hero-' . time() . '-' . $file->getClientOriginalName()
                    )
                    ->label('Video File'),
                Forms\Components\TextInput::make('youtube_link')
                    ->url()
                    ->maxLength(255)
                    ->label('YouTube Link'),
                Forms\Components\TextInput::make('cta_highlight_en')
                    ->maxLength(255)
                    ->label('CTA Highlight (English)'),
                Forms\Components\TextInput::make('cta_highlight_mr')
                    ->maxLength(255)
                    ->label('CTA Highlight (Marathi)'),
                Forms\Components\TextInput::make('order')
                    ->numeric()
                    ->default(0)
                    ->label('Display Order'),
                Forms\Components\Toggle::make('is_active')
                    ->default(true)
                    ->label('Active'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title_en')
                    ->searchable()
                    ->label('Title (EN)'),
                Tables\Columns\TextColumn::make('title_mr')
                    ->searchable()
                    ->label('Title (MR)')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('order')
                    ->sortable()
                    ->label('Order'),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('is_active')
                    ->label('Active')
                    ->query(fn ($query) => $query->where('is_active', true)),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->before(function ($record) {
                        // Delete the video file when the record is deleted
                        if ($record->video_url && Storage::disk('public')->exists($record->video_url)) {
                            Storage::disk('public')->delete($record->video_url);
                        }
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->before(function ($records) {
                            // Delete video files for all selected records
                            foreach ($records as $record) {
                                if ($record->video_url && Storage::disk('public')->exists($record->video_url)) {
                                    Storage::disk('public')->delete($record->video_url);
                                }
                            }
                        }),
                ]),
            ])
            ->reorderable('order');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHeroSections::route('/'),
            'create' => Pages\CreateHeroSection::route('/create'),
            'edit' => Pages\EditHeroSection::route('/{record}/edit'),
        ];
    }
}