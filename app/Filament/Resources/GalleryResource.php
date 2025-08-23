<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GalleryResource\Pages;
use App\Filament\Resources\GalleryResource\RelationManagers;
use App\Models\Gallery;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GalleryResource extends Resource
{
    protected static ?string $model = Gallery::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Page Content')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Textarea::make('description')
                            ->maxLength(500)
                            ->columnSpanFull(),
                    ]),
                    
                Forms\Components\Section::make('Gallery Images')
                    ->schema([
                        Forms\Components\Repeater::make('gallery_images')
                            ->schema([
                                Forms\Components\FileUpload::make('url')
                                    ->image()
                                    ->directory('gallery')
                                    ->required(),
                                Forms\Components\Select::make('category')
                                    ->options([
                                        'konkan_nature' => 'Konkan Nature',
                                        'konkan_fruits' => 'Konkan Fruits',
                                        'orchard_paradise' => 'Orchard Paradise',
                                        'dining_experience' => 'Dining Experience',
                                        'activities' => 'Activities',
                                    ])
                                    ->required(),
                            ])
                            ->grid(2)
                            ->defaultItems(1)
                            ->columnSpanFull(),
                    ]),
                    
                Forms\Components\Section::make('Amenities Highlights')
                    ->schema([
                        Forms\Components\Repeater::make('amenities_highlights')
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->required(),
                                Forms\Components\Select::make('icon')
                                    ->options([
                                        'pool' => 'Swimming Pool',
                                        'bed' => 'Luxury Rooms',
                                        'utensils' => 'Dining Experience',
                                        'tree' => 'Nature',
                                        'hiking' => 'Activities',
                                    ])
                                    ->required(),
                                Forms\Components\Textarea::make('description')
                                    ->required(),
                                Forms\Components\FileUpload::make('images')
                                    ->image()
                                    ->directory('amenities')
                                    ->multiple()
                                    ->maxFiles(3)
                                    ->required(),
                            ])
                            ->defaultItems(3)
                            ->columnSpanFull(),
                    ]),
                    
                Forms\Components\Section::make('Guest Experiences')
                    ->schema([
                        Forms\Components\Repeater::make('guest_experiences')
                            ->schema([
                                Forms\Components\FileUpload::make('url')
                                    ->image()
                                    ->directory('guest-experiences')
                                    ->required(),
                                Forms\Components\TextInput::make('position')
                                    ->required()
                                    ->numeric()
                                    ->minValue(1)
                                    ->maxValue(3),
                            ])
                            ->defaultItems(3)
                            ->maxItems(3)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
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
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListGalleries::route('/'),
            'create' => Pages\CreateGallery::route('/create'),
            'edit' => Pages\EditGallery::route('/{record}/edit'),
        ];
    }
}