<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectLocationResource\Pages;
use App\Filament\Resources\ProjectLocationResource\RelationManagers;
use App\Models\Project;
use App\Models\ProjectLocation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProjectLocationResource extends Resource
{
    protected static ?string $model = ProjectLocation::class;
    
    protected static ?string $navigationIcon = 'heroicon-o-map';
    protected static ?string $navigationGroup = 'Projects';
    protected static ?int $navigationSort = 5;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('project_id')
                    ->label('Project')
                    ->relationship('project', 'slug')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->unique(ignoreRecord: true)
                    ->getOptionLabelFromRecordUsing(fn (Project $record) => $record->slug),
                
                Forms\Components\TextInput::make('lat')
                    ->label('Latitude')
                    ->numeric()
                    ->step('0.00000001')
                    ->maxValue(90)
                    ->minValue(-90),
                
                Forms\Components\TextInput::make('lng')
                    ->label('Longitude')
                    ->numeric()
                    ->step('0.00000001')
                    ->maxValue(180)
                    ->minValue(-180),
                
                Forms\Components\Textarea::make('address_en')
                    ->label('Address (English)')
                    ->rows(2),
                
                Forms\Components\Textarea::make('address_mr')
                    ->label('Address (Marathi)')
                    ->rows(2),
                
                Forms\Components\TextInput::make('embed_url')
                    ->label('Embed URL')
                    ->url()
                    ->maxLength(500),
                
                Forms\Components\TextInput::make('zoom_level')
                    ->label('Zoom Level')
                    ->numeric()
                    ->default(15)
                    ->minValue(0)
                    ->maxValue(21)
                    ->required(),
                
                Forms\Components\Select::make('map_type')
                    ->label('Map Type')
                    ->options([
                        'roadmap' => 'Roadmap',
                        'satellite' => 'Satellite',
                        'hybrid' => 'Hybrid',
                        'terrain' => 'Terrain'
                    ])
                    ->default('roadmap')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('project.slug')
                    ->label('Project')
                    ->sortable()
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('lat')
                    ->label('Latitude')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('lng')
                    ->label('Longitude')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('address_en')
                    ->label('Address')
                    ->limit(30)
                    ->tooltip(fn ($record) => $record->address_en),
                
                Tables\Columns\TextColumn::make('zoom_level')
                    ->label('Zoom')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('map_type')
                    ->label('Map Type')
                    ->sortable(),
                
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
                    ->relationship('project', 'slug')
                    ->searchable()
                    ->preload()
                    ->label('Filter by Project'),
                
                Tables\Filters\SelectFilter::make('map_type')
                    ->options([
                        'roadmap' => 'Roadmap',
                        'satellite' => 'Satellite',
                        'hybrid' => 'Hybrid',
                        'terrain' => 'Terrain'
                    ])
                    ->label('Map Type'),
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjectLocations::route('/'),
            'create' => Pages\CreateProjectLocation::route('/create'),
            'edit' => Pages\EditProjectLocation::route('/{record}/edit'),
        ];
    }
}