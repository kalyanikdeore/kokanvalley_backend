<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WhyChooseResource\Pages;
use App\Filament\Resources\WhyChooseResource\RelationManagers;
use App\Models\WhyChoose;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class WhyChooseResource extends Resource
{
    protected static ?string $model = WhyChoose::class;

    protected static ?string $navigationIcon = 'heroicon-o-sparkles';

  protected static ?string $navigationGroup = 'About Us Page';
    protected static ?string $pluralModelLabel = 'Why Choose us';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('icon')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull()
                    ->helperText('Use FontAwesome icon class names like "fa-leaf"'),
                
                Forms\Components\Tabs::make('Titles')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('English')
                            ->schema([
                                Forms\Components\TextInput::make('title.en')
                                    ->label('Title (English)')
                                    ->required(),
                                Forms\Components\Textarea::make('description.en')
                                    ->label('Description (English)')
                                    ->required(),
                            ]),
                        Forms\Components\Tabs\Tab::make('Marathi')
                            ->schema([
                                Forms\Components\TextInput::make('title.mr')
                                    ->label('Title (Marathi)')
                                    ->required(),
                                Forms\Components\Textarea::make('description.mr')
                                    ->label('Description (Marathi)')
                                    ->required(),
                            ]),
                    ])->columnSpanFull(),
                
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
                Tables\Columns\TextColumn::make('title.en')
                    ->label('Title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->sortable(),
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
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->reorderable('sort_order');
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
            'index' => Pages\ListWhyChooses::route('/'),
            'create' => Pages\CreateWhyChoose::route('/create'),
            'edit' => Pages\EditWhyChoose::route('/{record}/edit'),
        ];
    }
}