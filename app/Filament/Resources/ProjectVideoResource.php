<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectVideoResource\Pages;
use App\Filament\Resources\ProjectVideoResource\RelationManagers;
use App\Models\Project;
use App\Models\ProjectVideo;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ProjectVideoResource extends Resource
{
    protected static ?string $model = ProjectVideo::class;

    protected static ?string $navigationIcon = 'heroicon-o-video-camera';
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
                    ->getOptionLabelFromRecordUsing(fn (Project $record) => $record->slug),
                Forms\Components\FileUpload::make('video_path')
                    ->label('Video')
                    ->acceptedFileTypes(['video/mp4', 'video/quicktime'])
                    ->required()
                    ->directory('project-videos')
                    ->preserveFilenames()
                    ->maxSize(10240),
                Forms\Components\FileUpload::make('thumbnail_path')
                    ->label('Thumbnail')
                    ->image()
                    ->directory('project-video-thumbnails')
                    ->preserveFilenames(),
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
                Tables\Columns\TextColumn::make('video_path')
                    ->label('Video File')
                    ->limit(30),
                Tables\Columns\ImageColumn::make('thumbnail_path')
                    ->label('Thumbnail')
                    ->circular(),
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
            'index' => Pages\ListProjectVideos::route('/'),
            'create' => Pages\CreateProjectVideo::route('/create'),
            'edit' => Pages\EditProjectVideo::route('/{record}/edit'),
        ];
    }
}