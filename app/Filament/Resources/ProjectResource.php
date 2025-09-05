<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Filament\Resources\ProjectResource\RelationManagers;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Basic Information')
                    ->schema([
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        Forms\Components\TextInput::make('icon')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('lat')
                            ->numeric(),
                        Forms\Components\TextInput::make('lng')
                            ->numeric(),
                        Forms\Components\Toggle::make('is_active')
                            ->required()
                            ->default(true),
                        Forms\Components\FileUpload::make('image')
                            ->image()
                            ->directory('projects')
                            ->visibility('public') // Make files publicly accessible
                            ->preserveFilenames() // Optional: preserve original filenames
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
                
                Forms\Components\Section::make('Translations')
                    ->schema([
                        Forms\Components\Tabs::make('Translations')
                            ->tabs([
                                Forms\Components\Tabs\Tab::make('English')
                                    ->schema([
                                        Forms\Components\TextInput::make('name.en')
                                            ->required()
                                            ->maxLength(255)
                                            ->label('Name (EN)'),
                                        Forms\Components\Textarea::make('description.en')
                                            ->required()
                                            ->label('Description (EN)'),
                                    ]),
                                Forms\Components\Tabs\Tab::make('Marathi')
                                    ->schema([
                                        Forms\Components\TextInput::make('name.mr')
                                            ->required()
                                            ->maxLength(255)
                                            ->label('Name (MR)'),
                                        Forms\Components\Textarea::make('description.mr')
                                            ->required()
                                            ->label('Description (MR)'),
                                    ]),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Name')
                    ->formatStateUsing(function ($state) {
                        return $state['mr'] ?? 'No translation';
                    })
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image')
                    ->disk('public') // Specify the disk
                    ->visibility('public'), // Make sure it's public
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
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
                Tables\Filters\Filter::make('is_active')
                    ->query(fn (Builder $query): Builder => $query->where('is_active', true))
                    ->label('Active'),
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
            RelationManagers\HighlightsRelationManager::class,
            RelationManagers\WhyChooseUsRelationManager::class,
            RelationManagers\ImagesRelationManager::class,
            RelationManagers\VideosRelationManager::class,
            RelationManagers\ProductsRelationManager::class,
            RelationManagers\TestimonialsRelationManager::class,
        ];
    }


    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}