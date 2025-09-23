<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AboutKokanValleyResource\Pages;
use App\Filament\Resources\AboutKokanValleyResource\RelationManagers;
use App\Models\AboutKokanValley;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;


class AboutKokanValleyResource extends Resource
{
    protected static ?string $model = AboutKokanValley::class;

    protected static ?string $navigationIcon = 'heroicon-o-information-circle';
    
    protected static ?string $navigationGroup = 'Room Management';
    protected static ?string $navigationLabel = 'Family Room About';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\TextInput::make('title.en')
                            ->label('Title (English)')
                            ->required(),
                        Forms\Components\TextInput::make('title.mr')
                            ->label('Title (Marathi)')
                            ->required(),
                        Forms\Components\FileUpload::make('image1_url')
                            ->label('Main Image')
                            ->image()
                            ->directory('about-section')
                            ->required(),
                        Forms\Components\FileUpload::make('image2_url')
                            ->label('Overlap Image')
                            ->image()
                            ->directory('about-section')
                            ->required(),
                        Forms\Components\Textarea::make('story.en')
                            ->label('Story (English)')
                            ->rows(5)
                            ->required(),
                        Forms\Components\Textarea::make('story.mr')
                            ->label('Story (Marathi)')
                            ->rows(5)
                            ->required(),
                        Forms\Components\TextInput::make('video_url')
                            ->label('YouTube Video URL')
                            ->url(),
                        Forms\Components\TextInput::make('watch_story_text.en')
                            ->label('Watch Story Text (English)')
                            ->required(),
                        Forms\Components\TextInput::make('watch_story_text.mr')
                            ->label('Watch Story Text (Marathi)')
                            ->required(),
                        Forms\Components\TextInput::make('overlap_image_alt.en')
                            ->label('Overlap Image Alt (English)')
                            ->required(),
                        Forms\Components\TextInput::make('overlap_image_alt.mr')
                            ->label('Overlap Image Alt (Marathi)')
                            ->required(),
                        Forms\Components\FileUpload::make('founder_image_url')
                            ->label('Founder Image')
                            ->image()
                            ->directory('about-section'),
                        Forms\Components\TextInput::make('founder_name')
                            ->label('Founder Name'),
                        Forms\Components\TextInput::make('founder_position')
                            ->label('Founder Position'),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title.en')
                    ->label('Title (English)')
                    ->limit(30),
                Tables\Columns\ImageColumn::make('image1_url')
                    ->label('Main Image'),
                Tables\Columns\ImageColumn::make('image2_url')
                    ->label('Overlap Image'),
                Tables\Columns\BooleanColumn::make('is_active')
                    ->label('Active'),
            ])
            ->filters([
                //
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
            'index' => Pages\ListAboutKokanValleys::route('/'),
            'create' => Pages\CreateAboutKokanValley::route('/create'),
            'edit' => Pages\EditAboutKokanValley::route('/{record}/edit'),
        ];
    }
}