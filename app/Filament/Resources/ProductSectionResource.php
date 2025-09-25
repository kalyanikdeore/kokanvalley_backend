<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductSectionResource\Pages;
use App\Models\ProductSection;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ProductSectionResource extends Resource
{
    protected static ?string $model = ProductSection::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';


       protected static ?string $navigationGroup = 'Product Page';
    protected static ?string $pluralModelLabel = 'Products';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Product Information')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('English')
                            ->schema([
                                Forms\Components\TextInput::make('name.en')
                                    ->label('Name (English)')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\Textarea::make('description.en')
                                    ->label('Description (English)')
                                    ->maxLength(65535)
                                    ->columnSpanFull(),
                                Forms\Components\TextInput::make('category.en')
                                    ->label('Category (English)')
                                    ->required()
                                    ->maxLength(255),
                            ]),
                        Forms\Components\Tabs\Tab::make('Marathi')
                            ->schema([
                                Forms\Components\TextInput::make('name.mr')
                                    ->label('Name (Marathi)')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\Textarea::make('description.mr')
                                    ->label('Description (Marathi)')
                                    ->maxLength(65535)
                                    ->columnSpanFull(),
                                Forms\Components\TextInput::make('category.mr')
                                    ->label('Category (Marathi)')
                                    ->required()
                                    ->maxLength(255),
                            ]),
                    ])
                    ->columnSpanFull(),
                
                Forms\Components\Section::make('Media')
                    ->schema([
                        Forms\Components\FileUpload::make('image')
                            ->label('Product Image')
                            ->image()
                            ->directory('products')
                            ->required()
                            ->columnSpanFull(),
                    ]),
                
                Forms\Components\TextInput::make('slug')
                    ->label('URL Slug')
                    ->unique(ignoreRecord: true)
                    ->maxLength(255)
                    ->helperText('Will be generated automatically if left empty'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Image')
                    ->size(40),
                
                Tables\Columns\TextColumn::make('name.en')
                    ->label('Name (EN)')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('name.mr')
                    ->label('Name (MR)')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                Tables\Columns\TextColumn::make('category.en')
                    ->label('Category')
                    ->searchable()
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
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
                Tables\Filters\SelectFilter::make('category')
                    ->options(function () {
                        // Fixed the query to properly extract JSON data
                        return ProductSection::query()
                            ->get()
                            ->pluck('category.en', 'category.en')
                            ->unique()
                            ->toArray();
                    })
                    ->label('Category'),
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
            // Add relations if needed
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProductSections::route('/'),
            'create' => Pages\CreateProductSection::route('/create'),
            'edit' => Pages\EditProductSection::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery();
    }
}