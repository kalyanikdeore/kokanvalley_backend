<?php
// app/Filament/Resources/ResortResource.php

namespace App\Filament\Resources;

use App\Filament\Resources\ResortResource\Pages;
use App\Filament\Resources\ResortResource\RelationManagers;
use App\Models\Resort;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Storage;

class ResortResource extends Resource
{
    protected static ?string $model = Resort::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-storefront';

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
                Forms\Components\FileUpload::make('image')
                    ->image()
                    ->directory('resorts')
                    ->visibility('public') // Add this line
                    ->required(),
                Forms\Components\Select::make('category')
                    ->options([
                        'property' => 'Konkan Nature',
                        'rooms' => 'Konkan Fruits',
                        'pool' => 'Orchard Paradise',
                    ])
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
                Tables\Columns\TextColumn::make('category')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image')
                    ->disk('public'),
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
            'index' => Pages\ListResorts::route('/'),
            'create' => Pages\CreateResort::route('/create'),
            'edit' => Pages\EditResort::route('/{record}/edit'),
        ];
    }
}