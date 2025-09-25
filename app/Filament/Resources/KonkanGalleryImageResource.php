<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KonkanGalleryImageResource\Pages;
use App\Filament\Resources\KonkanGalleryImageResource\RelationManagers;
use App\Models\KonkanGalleryImage;
use App\Models\KonkanGalleryCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KonkanGalleryImageResource extends Resource
{
    protected static ?string $model = KonkanGalleryImage::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';
 protected static ?string $navigationGroup = 'Gallery page';
    protected static ?string $navigationLabel = 'Konkan Gallery';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('category_id')
                    ->relationship('category', 'name_en')
                    ->required()
                    ->searchable()
                    ->preload(),
                Forms\Components\FileUpload::make('image_path')
                    ->image()
                    ->required()
                    ->disk('public') // Use the public disk
                    ->directory('konkan-gallery') // This will store in public/uploads/konkan-gallery
                    ->preserveFilenames(),
                Forms\Components\TextInput::make('sort_order')
                    ->numeric()
                    ->default(0),
                Forms\Components\Toggle::make('is_active')
                    ->required()
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_path')
                    ->disk('public') // Use the public disk
                    ->size(80),
                Tables\Columns\TextColumn::make('category.name_en')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
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
                Tables\Filters\SelectFilter::make('category')
                    ->relationship('category', 'name_en')
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
            'index' => Pages\ListKonkanGalleryImages::route('/'),
            'create' => Pages\CreateKonkanGalleryImage::route('/create'),
            'edit' => Pages\EditKonkanGalleryImage::route('/{record}/edit'),
        ];
    }
}