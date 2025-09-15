<?php

namespace App\Filament\Resources\ProjectResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class TestimonialsRelationManager extends RelationManager

{
    protected static string $relationship = 'testimonials';

    // NON-STATIC method as required
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('location_en')
                    ->label('Location (English)')
                    ->maxLength(255),
                Forms\Components\TextInput::make('location_mr')
                    ->label('Location (Marathi)')
                    ->maxLength(255),
                Forms\Components\Textarea::make('quote_en')
                    ->label('Quote (English)')
                    ->required(),
                Forms\Components\Textarea::make('quote_mr')
                    ->label('Quote (Marathi)')
                    ->required(),
                Forms\Components\Select::make('rating')
                    ->options([
                        1 => '1 Star',
                        2 => '2 Stars',
                        3 => '3 Stars',
                        4 => '4 Stars',
                        5 => '5 Stars',
                    ])
                    ->required()
                    ->default(5),
                Forms\Components\FileUpload::make('image')
                    ->label('Profile Image')
                    ->image()
                    ->directory('testimonial-images')
                    ->preserveFilenames()
                    ->maxSize(1024),
            ]);
    }

    // NON-STATIC method as required
    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->size(50)
                    ->circular(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('location_en')
                    ->label('Location')
                    ->limit(20),
                Tables\Columns\IconColumn::make('rating')
                    ->icon(fn ($state) => 'heroicon-o-star')
                    ->color('warning')
                    ->getStateUsing(fn ($record) => str_repeat('⭐', $record->rating)),
            ])
            ->filters([])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
