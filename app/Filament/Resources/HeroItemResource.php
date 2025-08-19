<?php

namespace App\Filament\Resources;

use App\Filament\Resources\HeroItemResource\Pages;
use App\Filament\Resources\HeroItemResource\RelationManagers;
use App\Models\HeroItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class HeroItemResource extends Resource
{
    protected static ?string $model = HeroItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationGroup = 'Home Page';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Grid::make()
                    ->schema([
                        Forms\Components\TextInput::make('order')
                            ->numeric()
                            ->default(0),
                        Forms\Components\Toggle::make('is_active')
                            ->default(true),
                    ])->columns(2),
                
                Forms\Components\TextInput::make('video_url')
                    ->label('Video URL')
                    ->required()
                    ->maxLength(255),
                
                Forms\Components\TextInput::make('youtube_link')
                    ->label('YouTube Link')
                    ->required()
                    ->url()
                    ->maxLength(255),
                
                Forms\Components\Section::make('Title')
                    ->schema([
                        Forms\Components\TextInput::make('title.en')
                            ->label('English Title')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('title.mr')
                            ->label('Marathi Title')
                            ->required()
                            ->maxLength(255),
                    ])->columns(2),
                
                Forms\Components\Section::make('Description')
                    ->schema([
                        Forms\Components\Textarea::make('description.en')
                            ->label('English Description')
                            ->required()
                            ->maxLength(65535),
                        Forms\Components\Textarea::make('description.mr')
                            ->label('Marathi Description')
                            ->required()
                            ->maxLength(65535),
                    ])->columns(2),
                
                Forms\Components\Section::make('CTA Highlight (Optional)')
                    ->schema([
                        Forms\Components\TextInput::make('cta_highlight.en')
                            ->label('English CTA Highlight')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('cta_highlight.mr')
                            ->label('Marathi CTA Highlight')
                            ->maxLength(255),
                    ])->columns(2)
                    ->collapsible(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('title.en')
                    ->label('Title (EN)')
                    ->searchable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('video_url')
                    ->searchable()
                    ->limit(30),
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
            ->reorderable('order');
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
            'index' => Pages\ListHeroItems::route('/'),
            'create' => Pages\CreateHeroItem::route('/create'),
            'edit' => Pages\EditHeroItem::route('/{record}/edit'),
        ];
    }
}