<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectProductResource\Pages;
use App\Models\Project;
use App\Models\ProjectProduct;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProjectProductResource extends Resource
{
    protected static ?string $model = ProjectProduct::class;

    protected static ?string $navigationIcon = 'heroicon-o-cube';
    protected static ?string $navigationGroup = 'Projects';
    protected static ?int $navigationSort = 6;

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
                    ->getOptionLabelFromRecordUsing(fn (Project $record) => $record->slug)
                    ->getSearchResultsUsing(fn (string $search) => Project::where('slug', 'like', "%{$search}%")->pluck('slug', 'id')),
                Forms\Components\TextInput::make('title_en')
                    ->label('Title (English)')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('title_mr')
                    ->label('Title (Marathi)')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('description_en')
                    ->label('Description (English)')
                    ->required(),
                Forms\Components\Textarea::make('description_mr')
                    ->label('Description (Marathi)')
                    ->required(),
                Forms\Components\DatePicker::make('date')
                    ->required(),
                Forms\Components\TextInput::make('order')
                    ->numeric()
                    ->default(0),
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
                Tables\Columns\TextColumn::make('title_en')
                    ->label('Title (EN)')
                    ->limit(30),
                Tables\Columns\TextColumn::make('date')
                    ->date(),
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
                    ->label('Filter by Project Slug'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('manageMedia')
                    ->label('Media')
                    ->icon('heroicon-o-photo')
                    ->url(fn ($record) => route('filament.admin.resources.product-media.index', ['project_product_id' => $record->id])),
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
            'index' => Pages\ListProjectProducts::route('/'),
            'create' => Pages\CreateProjectProduct::route('/create'),
            'edit' => Pages\EditProjectProduct::route('/{record}/edit'),
        ];
    }
}