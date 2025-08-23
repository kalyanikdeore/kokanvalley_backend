<?php
// app/Filament/Resources/AmenityResource.php

namespace App\Filament\Resources;

use App\Filament\Resources\AmenityResource\Pages;
use App\Models\Amenity;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

class AmenityResource extends Resource
{
    protected static ?string $model = Amenity::class;

    protected static ?string $navigationIcon = 'heroicon-o-sparkles';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title.en')
                    ->label('Title (English)')
                    ->required(),
                Forms\Components\TextInput::make('title.mr')
                    ->label('Title (Marathi)')
                    ->required(),
                Forms\Components\Textarea::make('description.en')
                    ->label('Description (English)')
                    ->required(),
                Forms\Components\Textarea::make('description.mr')
                    ->label('Description (Marathi)')
                    ->required(),
                Forms\Components\Select::make('icon')
                    ->options([
                        'pool' => 'Pool',
                        'bed' => 'Bed',
                        'utensils' => 'Utensils',
                        'tree' => 'Tree',
                    ])
                    ->required(),
                Forms\Components\FileUpload::make('images')
                    ->image()
                    ->multiple()
                    ->directory('amenities')
                    ->visibility('public')
                    ->preserveFilenames()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title.en')
                    ->label('Title')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('images')
                    ->stacked()
                    ->limit(3)
                    ->circular(),
                Tables\Columns\TextColumn::make('icon')
                    ->searchable(),
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
            'index' => Pages\ListAmenities::route('/'),
            'create' => Pages\CreateAmenity::route('/create'),
            'edit' => Pages\EditAmenity::route('/{record}/edit'),
        ];
    }
}