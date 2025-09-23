<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StaticAmenitiesGalleryResource\Pages;
use App\Models\StaticAmenitiesGallery;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class StaticAmenitiesGalleryResource extends Resource
{
    protected static ?string $model = StaticAmenitiesGallery::class;
    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationGroup = 'Content Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Label')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('English')
                            ->schema([
                                Forms\Components\TextInput::make('title.en')
                                    ->label('Title (English)')
                                    ->required(),
                                Forms\Components\Textarea::make('description.en')
                                    ->label('Description (English)')
                                    ->required()
                                    ->rows(3),
                            ]),
                        Forms\Components\Tabs\Tab::make('Marathi')
                            ->schema([
                                Forms\Components\TextInput::make('title.mr')
                                    ->label('Title (Marathi)')
                                    ->required(),
                                Forms\Components\Textarea::make('description.mr')
                                    ->label('Description (Marathi)')
                                    ->required()
                                    ->rows(3),
                            ]),
                    ]),
                Forms\Components\FileUpload::make('images')
                    ->label('Gallery Images')
                    ->multiple()
                    ->image()
                    ->maxFiles(10)
                    ->disk('public')
                    ->directory('static-amenities-gallery')
                    ->visibility('public')
                    ->preserveFilenames()
                    ->getUploadedFileNameForStorageUsing(
                        fn (TemporaryUploadedFile $file): string => 
                            (string) str($file->getClientOriginalName())
                                ->prepend('amenity-'.time().'-'),
                    )
                    ->reorderable()
                    ->appendFiles()
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('sort_order')
                    ->numeric()
                    ->default(0),
                Forms\Components\Toggle::make('is_active')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title.en')
                    ->label('Title (EN)')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('title.mr')
                    ->label('Title (MR)')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\ImageColumn::make('images')
                    ->label('Preview Image')
                    ->disk('public')
                    ->getStateUsing(function ($record) {
                        $images = $record->images;
                        return count($images) > 0 ? $images[0] : null;
                    })
                    ->circular(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->sortable(),
                Tables\Columns\BooleanColumn::make('is_active')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('is_active')
                    ->query(fn ($query) => $query->where('is_active', true))
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->before(function ($record) {
                        // Delete associated images from storage
                        foreach ($record->images as $image) {
                            Storage::disk('public')->delete($image);
                        }
                    }),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make()
                    ->before(function ($records) {
                        // Delete associated images for all selected records
                        foreach ($records as $record) {
                            foreach ($record->images as $image) {
                                Storage::disk('public')->delete($image);
                            }
                        }
                    }),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStaticAmenitiesGalleries::route('/'),
            'create' => Pages\CreateStaticAmenitiesGallery::route('/create'),
            'edit' => Pages\EditStaticAmenitiesGallery::route('/{record}/edit'),
        ];
    }
}