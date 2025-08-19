<?php
// app/Filament/Resources/AboutKonkanResource.php

namespace App\Filament\Resources;

use App\Filament\Resources\AboutKonkanResource\Pages;
use App\Models\AboutKonkan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AboutKonkanResource extends Resource
{
    protected static ?string $model = AboutKonkan::class;

    protected static ?string $navigationIcon = 'heroicon-o-information-circle';

    protected static ?string $navigationGroup = 'Content Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('About Konkan Content')
                    ->schema([
                        Forms\Components\TextInput::make('title.en')
                            ->label('Title (English)')
                            ->required(),
                        Forms\Components\TextInput::make('title.mr')
                            ->label('Title (Marathi)')
                            ->required(),
                        Forms\Components\Textarea::make('story.en')
                            ->label('Story (English)')
                            ->required()
                            ->rows(5),
                        Forms\Components\Textarea::make('story.mr')
                            ->label('Story (Marathi)')
                            ->required()
                            ->rows(5),
                        Forms\Components\FileUpload::make('image1_url')
                            ->label('Main Image')
                            ->image()
                            ->directory('about-konkan')
                            ->required(),
                        Forms\Components\FileUpload::make('image2_url')
                            ->label('Overlap Image')
                            ->image()
                            ->directory('about-konkan')
                            ->required(),
                        Forms\Components\TextInput::make('video_url')
                            ->label('YouTube Video URL')
                            ->url(),
                        Forms\Components\TextInput::make('watch_story_text.en')
                            ->label('Watch Story Text (English)')
                            ->default('Watch our Story'),
                        Forms\Components\TextInput::make('watch_story_text.mr')
                            ->label('Watch Story Text (Marathi)')
                            ->default('आमची कहाणी पहा'),
                        Forms\Components\TextInput::make('overlap_image_alt.en')
                            ->label('Overlap Image Alt (English)')
                            ->default('Leela Farmhouse garden view'),
                        Forms\Components\TextInput::make('overlap_image_alt.mr')
                            ->label('Overlap Image Alt (Marathi)')
                            ->default('लीला फार्महाऊस बाग दृश्य'),
                    ])->columns(1),
                
                Forms\Components\Section::make('Founder Information (Optional)')
                    ->schema([
                        Forms\Components\FileUpload::make('founder_image_url')
                            ->label('Founder Image')
                            ->image()
                            ->directory('about-konkan/founder'),
                        Forms\Components\TextInput::make('founder_name.en')
                            ->label('Founder Name (English)'),
                        Forms\Components\TextInput::make('founder_name.mr')
                            ->label('Founder Name (Marathi)'),
                        Forms\Components\TextInput::make('founder_position.en')
                            ->label('Founder Position (English)'),
                        Forms\Components\TextInput::make('founder_position.mr')
                            ->label('Founder Position (Marathi)'),
                    ])->columns(1),
                
                Forms\Components\Toggle::make('is_active')
                    ->label('Active')
                    ->default(true)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->sortable(),
                Tables\Columns\TextColumn::make('title.en')
                    ->label('Title')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image1_url')
                    ->label('Main Image'),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Active'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('is_active')
                    ->query(fn ($query) => $query->where('is_active', true))
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListAboutKonkans::route('/'),
            'create' => Pages\CreateAboutKonkan::route('/create'),
            'edit' => Pages\EditAboutKonkan::route('/{record}/edit'),
        ];
    }
}