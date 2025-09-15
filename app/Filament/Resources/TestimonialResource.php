<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TestimonialResource\Pages;
use App\Models\Testimonial;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;

class TestimonialResource extends Resource
{
    protected static ?string $model = Testimonial::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static ?string $navigationGroup = 'Content';
    protected static ?int $navigationSort = 1;

    // Form schema
    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('project_id')
                    ->relationship('project', 'name') // Make sure your projects table has 'name'
                    ->searchable()
                    ->required(),

                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Textarea::make('content')
                    ->label('Quote')
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

                Forms\Components\FileUpload::make('avatar_path')
                    ->label('Profile Image')
                    ->image()
                    ->directory('testimonial-images')
                    ->preserveFilenames()
                    ->maxSize(1024),
            ]);
    }

    // Table schema
    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('avatar_path')
                    ->label('Image')
                    ->size(50)
                    ->circular(),

                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('project.name')
                    ->label('Project')
                    ->sortable(),

                Tables\Columns\TextColumn::make('content')
                    ->label('Quote')
                    ->limit(50),

                Tables\Columns\IconColumn::make('rating')
                    ->icon('heroicon-o-star')
                    ->color('warning')
                    ->getStateUsing(fn ($record) => str_repeat('⭐', $record->rating)),

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
                Tables\Filters\SelectFilter::make('project')
                    ->relationship('project', 'name'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTestimonials::route('/'),
            'create' => Pages\CreateTestimonial::route('/create'),
            'edit' => Pages\EditTestimonial::route('/{record}/edit'),
        ];
    }
}
