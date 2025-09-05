<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectHighlightResource\Pages;
use App\Filament\Resources\ProjectHighlightResource\RelationManagers;
use App\Models\Project;
use App\Models\ProjectHighlight;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProjectHighlightResource extends Resource
{
    protected static ?string $model = ProjectHighlight::class;

    protected static ?string $navigationIcon = 'heroicon-o-sparkles';
    protected static ?string $navigationGroup = 'Projects';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('project_id')
                    ->label('Project')
                    ->relationship('project', 'slug') // Use slug or another existing field
                    ->required()
                    ->searchable()
                    ->preload()
                    ->getOptionLabelFromRecordUsing(fn (Project $record) => $record->slug), // Display slug as label
                Forms\Components\Textarea::make('highlight_en')
                    ->label('Highlight (English)')
                    ->required()
                    ->maxLength(65535),
                Forms\Components\Textarea::make('highlight_mr')
                    ->label('Highlight (Marathi)')
                    ->required()
                    ->maxLength(65535),
                Forms\Components\TextInput::make('order')
                    ->numeric()
                    ->default(0)
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('project.slug')
                    ->label('Project Slug')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('highlight_en')
                    ->label('English Highlight')
                    ->limit(50)
                    ->searchable(),
                Tables\Columns\TextColumn::make('highlight_mr')
                    ->label('Marathi Highlight')
                    ->limit(50)
                    ->searchable(),
                Tables\Columns\TextColumn::make('order')
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
            'index' => Pages\ListProjectHighlights::route('/'),
            'create' => Pages\CreateProjectHighlight::route('/create'),
            'edit' => Pages\EditProjectHighlight::route('/{record}/edit'),
        ];
    }
}