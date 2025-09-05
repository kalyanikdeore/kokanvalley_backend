<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectAmenityResource\Pages;
use App\Filament\Resources\ProjectAmenityResource\RelationManagers;
use App\Models\ProjectAmenity;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\ToggleColumn;
use Illuminate\Support\Facades\Storage;

class ProjectAmenityResource extends Resource
{
    protected static ?string $model = ProjectAmenity::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Content Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Amenity Information')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('title.en')
                                    ->label('Title (English)')
                                    ->required(),
                                TextInput::make('title.mr')
                                    ->label('Title (Marathi)')
                                    ->required(),
                            ]),
                        Grid::make(2)
                            ->schema([
                                Textarea::make('description.en')
                                    ->label('Description (English)')
                                    ->rows(3)
                                    ->required(),
                                Textarea::make('description.mr')
                                    ->label('Description (Marathi)')
                                    ->rows(3)
                                    ->required(),
                            ]),
                    ]),
                
                Section::make('Images')
                    ->schema([
                        FileUpload::make('images')
                            ->label('Amenity Images')
                            ->multiple()
                            ->image()
                            ->directory('amenities')
                            ->reorderable()
                            ->appendFiles()
                            ->maxFiles(5)
                            ->required(),
                    ]),
                
                Section::make('Settings')
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('sort_order')
                                    ->numeric()
                                    ->default(0),
                                Toggle::make('is_active')
                                    ->default(true)
                                    ->label('Active'),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title.en')
                    ->label('Title (EN)')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('title.mr')
                    ->label('Title (MR)')
                    ->searchable()
                    ->sortable(),
                ImageColumn::make('images')
                    ->label('Preview Image')
                    ->getStateUsing(function ($record) {
                        $images = $record->images;
                        return count($images) > 0 ? $images[0] : null;
                    })
                    ->circular(),
                TextColumn::make('sort_order')
                    ->sortable(),
                ToggleColumn::make('is_active')
                    ->label('Active'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\Filter::make('is_active')
                    ->query(fn (Builder $query): Builder => $query->where('is_active', true))
                    ->label('Only Active'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('sort_order', 'asc');
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
            'index' => Pages\ListProjectAmenities::route('/'),
            'create' => Pages\CreateProjectAmenity::route('/create'),
            'edit' => Pages\EditProjectAmenity::route('/{record}/edit'),
        ];
    }
}