<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AboutSectionResource\Pages;
use App\Filament\Resources\AboutSectionResource\RelationManagers;
use App\Models\AboutSection;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AboutSectionResource extends Resource
{
    protected static ?string $model = AboutSection::class;

    protected static ?string $navigationIcon = 'heroicon-o-information-circle';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Titles')
                    ->schema([
                        Forms\Components\TextInput::make('title_en')
                            ->required()
                            ->maxLength(255)
                            ->label('Title (English)'),
                        Forms\Components\TextInput::make('title_mr')
                            ->required()
                            ->maxLength(255)
                            ->label('Title (Marathi)'),
                    ])->columns(2),
                
                Forms\Components\Section::make('Subtitles')
                    ->schema([
                        Forms\Components\TextInput::make('subtitle_en')
                            ->required()
                            ->maxLength(255)
                            ->label('Subtitle (English)'),
                        Forms\Components\TextInput::make('subtitle_mr')
                            ->required()
                            ->maxLength(255)
                            ->label('Subtitle (Marathi)'),
                    ])->columns(2),
                
                Forms\Components\Section::make('Descriptions')
                    ->schema([
                        Forms\Components\Textarea::make('description_en')
                            ->required()
                            ->label('Description (English)')
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('description_mr')
                            ->required()
                            ->label('Description (Marathi)')
                            ->columnSpanFull(),
                    ]),
                
                Forms\Components\Section::make('Statistics')
                    ->schema([
                        Forms\Components\Repeater::make('stats')
                            ->schema([
                                Forms\Components\TextInput::make('value')
                                    ->required(),
                                Forms\Components\TextInput::make('label_en')
                                    ->required()
                                    ->label('Label (English)'),
                                Forms\Components\TextInput::make('label_mr')
                                    ->required()
                                    ->label('Label (Marathi)'),
                            ])
                            ->default([
                                [
                                    'value' => '300+ km',
                                    'label_en' => 'Coastline',
                                    'label_mr' => 'किनारपट्टी'
                                ],
                                [
                                    'value' => '50+',
                                    'label_en' => 'Beaches',
                                    'label_mr' => 'वाळवंट'
                                ],
                                [
                                    'value' => '1000+',
                                    'label_en' => 'Years of History',
                                    'label_mr' => 'इतिहासाचे वर्ष'
                                ],
                                [
                                    'value' => '12+',
                                    'label_en' => 'Ancient Fortresses',
                                    'label_mr' => 'प्राचीन किल्ले'
                                ]
                            ])
                            ->columns(3),
                    ]),
                
                Forms\Components\Section::make('Image Labels')
                    ->schema([
                        Forms\Components\Repeater::make('image_labels')
                            ->schema([
                                Forms\Components\TextInput::make('en')
                                    ->required()
                                    ->label('English'),
                                Forms\Components\TextInput::make('mr')
                                    ->required()
                                    ->label('Marathi'),
                            ])
                            ->default([
                                ['en' => 'Golden Beaches', 'mr' => 'सोनेरी वाळवंट'],
                                ['en' => 'Lush Hills', 'mr' => 'हिरवेगार डोंगर'],
                                ['en' => 'Local Cuisine', 'mr' => 'स्थानिक पाककृती'],
                                ['en' => 'Coastal Villages', 'mr' => 'किनारी गावे'],
                            ])
                            ->columns(2),
                    ]),
                
                Forms\Components\Section::make('Images')
                    ->schema([
                        Forms\Components\FileUpload::make('image_beach')
                            ->required()
                            ->image()
                            ->disk('public') // Specify the disk
                            ->directory('about-section') // This will create storage/app/public/about-section
                            ->visibility('public') // Make files publicly accessible
                            ->label('Beach Image'),
                        
                        Forms\Components\FileUpload::make('image_hills')
                            ->required()
                            ->image()
                            ->disk('public')
                            ->directory('about-section')
                            ->visibility('public')
                            ->label('Hills Image'),
                        
                        Forms\Components\FileUpload::make('image_cuisine')
                            ->required()
                            ->image()
                            ->disk('public')
                            ->directory('about-section')
                            ->visibility('public')
                            ->label('Cuisine Image'),
                        
                        Forms\Components\FileUpload::make('image_villages')
                            ->required()
                            ->image()
                            ->disk('public')
                            ->directory('about-section')
                            ->visibility('public')
                            ->label('Villages Image'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title_en')
                    ->searchable(),
                Tables\Columns\TextColumn::make('title_mr')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image_beach')
                    ->disk('public')
                    ->label('Beach Image')
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\ImageColumn::make('image_hills')
                    ->disk('public')
                    ->label('Hills Image')
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListAboutSections::route('/'),
            'create' => Pages\CreateAboutSection::route('/create'),
            'edit' => Pages\EditAboutSection::route('/{record}/edit'),
        ];
    }
}