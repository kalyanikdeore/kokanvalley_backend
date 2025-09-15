<?php

namespace App\Filament\Resources\ProjectResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class LocationRelationManager extends RelationManager
{
    protected static string $relationship = 'location';

    protected static ?string $title = 'Project Location';

    protected static ?string $label = 'Location';
    protected static ?string $pluralLabel = 'Location';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Coordinates')
                    ->schema([
                        Forms\Components\TextInput::make('lat')
                            ->label('Latitude')
                            ->numeric()
                            ->step('0.00000001')
                            ->maxValue(90)
                            ->minValue(-90)
                            ->requiredWith('lng')
                            ->helperText('Enter latitude coordinate (e.g., 19.076090)'),
                        
                        Forms\Components\TextInput::make('lng')
                            ->label('Longitude')
                            ->numeric()
                            ->step('0.00000001')
                            ->maxValue(180)
                            ->minValue(-180)
                            ->requiredWith('lat')
                            ->helperText('Enter longitude coordinate (e.g., 72.877426)'),
                    ])
                    ->columns(2),
                
                Forms\Components\Section::make('Address Information')
                    ->schema([
                        Forms\Components\Textarea::make('address_en')
                            ->label('Address (English)')
                            ->rows(2)
                            ->maxLength(500)
                            ->helperText('Full address in English'),
                        
                        Forms\Components\Textarea::make('address_mr')
                            ->label('Address (Marathi)')
                            ->rows(2)
                            ->maxLength(500)
                            ->helperText('Full address in Marathi'),
                    ]),
                
                Forms\Components\Section::make('Map Settings')
                    ->schema([
                        Forms\Components\TextInput::make('embed_url')
                            ->label('Custom Embed URL')
                            ->url()
                            ->maxLength(500)
                            ->helperText('Optional: Custom Google Maps embed URL. If not provided, will be generated from coordinates.'),
                        
                        Forms\Components\TextInput::make('zoom_level')
                            ->label('Zoom Level')
                            ->numeric()
                            ->default(15)
                            ->minValue(0)
                            ->maxValue(21)
                            ->required()
                            ->helperText('Map zoom level (0-21, default: 15)'),
                        
                        Forms\Components\Select::make('map_type')
                            ->label('Map Type')
                            ->options([
                                'roadmap' => 'Roadmap',
                                'satellite' => 'Satellite',
                                'hybrid' => 'Hybrid',
                                'terrain' => 'Terrain'
                            ])
                            ->default('roadmap')
                            ->required()
                            ->helperText('Type of map to display'),
                    ])
                    ->columns(3),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('address_en')
            ->columns([
                Tables\Columns\TextColumn::make('lat')
                    ->label('Latitude')
                    ->sortable()
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('lng')
                    ->label('Longitude')
                    ->sortable()
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('address_en')
                    ->label('Address (EN)')
                    ->limit(30)
                    ->tooltip(fn ($record) => $record->address_en)
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('address_mr')
                    ->label('Address (MR)')
                    ->limit(30)
                    ->tooltip(fn ($record) => $record->address_mr)
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('zoom_level')
                    ->label('Zoom')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('map_type')
                    ->label('Map Type')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: false),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Add Location')
                    ->icon('heroicon-o-map-pin'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()
                    ->icon('heroicon-o-pencil'),
                
                Tables\Actions\DeleteAction::make()
                    ->icon('heroicon-o-trash'),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->emptyStateHeading('No location set')
            ->emptyStateDescription('Add a location to display it on the project details page.')
            ->emptyStateActions([
                Tables\Actions\CreateAction::make()
                    ->label('Add Location')
                    ->icon('heroicon-o-map-pin'),
            ]);
    }
}