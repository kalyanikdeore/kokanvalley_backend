<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VisionMissionResource\Pages;
use App\Filament\Resources\VisionMissionResource\RelationManagers;
use App\Models\VisionMission;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class VisionMissionResource extends Resource
{
    protected static ?string $model = VisionMission::class;
    protected static ?string $navigationIcon = 'heroicon-o-light-bulb';
    protected static ?string $navigationLabel = 'Vision & Mission';
    protected static ?string $modelLabel = 'Vision & Mission';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Section Title')
                    ->schema([
                        Forms\Components\TextInput::make('title.en')
                            ->label('Title (English)')
                            ->required(),
                        Forms\Components\TextInput::make('title.mr')
                            ->label('Title (Marathi)')
                            ->required(),
                    ]),
                
                Forms\Components\Section::make('Vision')
                    ->schema([
                        Forms\Components\TextInput::make('vision_title.en')
                            ->label('Vision Title (English)')
                            ->required(),
                        Forms\Components\TextInput::make('vision_title.mr')
                            ->label('Vision Title (Marathi)')
                            ->required(),
                        Forms\Components\Textarea::make('vision_content.en')
                            ->label('Vision Content (English)')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('vision_content.mr')
                            ->label('Vision Content (Marathi)')
                            ->required()
                            ->columnSpanFull(),
                    ]),
                
                Forms\Components\Section::make('Mission')
                    ->schema([
                        Forms\Components\TextInput::make('mission_title.en')
                            ->label('Mission Title (English)')
                            ->required(),
                        Forms\Components\TextInput::make('mission_title.mr')
                            ->label('Mission Title (Marathi)')
                            ->required(),
                        Forms\Components\Textarea::make('mission_content.en')
                            ->label('Mission Content (English)')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('mission_content.mr')
                            ->label('Mission Content (Marathi)')
                            ->required()
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title.en')
                    ->label('Title')
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
            'index' => \App\Filament\Resources\VisionMissionResource\Pages\ListVisionMissions::route('/'),
            'create' => \App\Filament\Resources\VisionMissionResource\Pages\CreateVisionMission::route('/create'),
            'edit' => \App\Filament\Resources\VisionMissionResource\Pages\EditVisionMission::route('/{record}/edit'),
        ];
    }
    
    // Ensure only one record can be created
    public static function canCreate(): bool
    {
        return VisionMission::count() === 0;
    }
}
