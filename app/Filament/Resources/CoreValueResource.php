<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CoreValueResource\Pages;
use App\Filament\Resources\CoreValueResource\RelationManagers;
use App\Models\CoreValue;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CoreValueResource extends Resource
{
    protected static ?string $model = CoreValue::class;

    protected static ?string $navigationIcon = 'heroicon-o-sparkles';
       protected static ?string $navigationGroup = 'About Us Page';
    protected static ?string $pluralModelLabel = 'Core Value';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('icon')
                    ->required()
                    ->maxLength(10),
                
                Forms\Components\Section::make('Title')
                    ->schema([
                        Forms\Components\TextInput::make('title.en')
                            ->label('English Title')
                            ->required(),
                        Forms\Components\TextInput::make('title.mr')
                            ->label('Marathi Title')
                            ->required(),
                    ]),
                
                Forms\Components\Section::make('Description')
                    ->schema([
                        Forms\Components\Textarea::make('description.en')
                            ->label('English Description')
                            ->required(),
                        Forms\Components\Textarea::make('description.mr')
                            ->label('Marathi Description')
                            ->required(),
                    ]),
                
                Forms\Components\TextInput::make('sort_order')
                    ->numeric()
                    ->default(0),
                
                Forms\Components\Toggle::make('is_active')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('icon'),
                Tables\Columns\TextColumn::make('title.en')
                    ->label('Title (EN)'),
                Tables\Columns\TextColumn::make('title.mr')
                    ->label('Title (MR)'),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('active')
                    ->query(fn (Builder $query): Builder => $query->where('is_active', true)),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListCoreValues::route('/'),
            'create' => Pages\CreateCoreValue::route('/create'),
            'edit' => Pages\EditCoreValue::route('/{record}/edit'),
        ];
    }
}
