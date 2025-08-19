<?php
// app/Filament/Resources/ProductResource.php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Product Information')
                    ->schema([
                        Forms\Components\TextInput::make('name.en')
                            ->label('Name (English)')
                            ->required(),
                        Forms\Components\TextInput::make('name.mr')
                            ->label('Name (Marathi)')
                            ->required(),
                        Forms\Components\Textarea::make('description.en')
                            ->label('Description (English)')
                            ->required(),
                        Forms\Components\Textarea::make('description.mr')
                            ->label('Description (Marathi)')
                            ->required(),
                        Forms\Components\TextInput::make('price.en')
                            ->label('Price (English)')
                            ->required(),
                        Forms\Components\TextInput::make('price.mr')
                            ->label('Price (Marathi)')
                            ->required(),
                    ])->columns(2),
                
                Section::make('Category & Image')
                    ->schema([
                        Forms\Components\Select::make('category.en')
                            ->label('Category (English)')
                            ->options([
                                'Organic Alphonso Mangoes' => 'Organic Alphonso Mangoes',
                                'Authentic Konkan Cashews' => 'Authentic Konkan Cashews',
                                'Jamun & Avocado' => 'Jamun & Avocado',
                                'Natural Fruit-processed Products- Mango ,Pulp' => 'Natural Fruit-processed Products- Mango ,Pulp',
                                'Spices, Pickles, Sweet Preserves' => 'Spices, Pickles, Sweet Preserves',
                            ])
                            ->required(),
                        Forms\Components\Select::make('category.mr')
                            ->label('Category (Marathi)')
                            ->options([
                                'ऑर्गेनिक अल्फांसो मनुके' => 'ऑर्गेनिक अल्फांसो मनुके',
                                'खरे कोंकणी काजू' => 'खरे कोंकणी काजू',
                                'जांभूळ आणि एव्होकॅडो' => 'जांभूळ आणि एव्होकॅडो',
                                'नैसर्गिक फळ-प्रक्रिया उत्पादने - आंबा पल्प' => 'नैसर्गिक फळ-प्रक्रिया उत्पादने - आंबा पल्प',
                                'मसाले, लोणचे, गोड पदार्थ' => 'मसाले, लोणचे, गोड पदार्थ',
                            ])
                            ->required(),
                        FileUpload::make('image')
                            ->label('Product Image')
                            ->directory('products')
                            ->image()
                            ->required()
                            ->disk('public'),
                        Toggle::make('is_active')
                            ->label('Active')
                            ->default(true),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Image'),
                Tables\Columns\TextColumn::make('name.en')
                    ->label('Name (English)')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.en')
                    ->label('Category')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price.en')
                    ->label('Price')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
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
                Tables\Filters\SelectFilter::make('category.en')
                    ->label('Category')
                    ->options([
                        'Organic Alphonso Mangoes' => 'Organic Alphonso Mangoes',
                        'Authentic Konkan Cashews' => 'Authentic Konkan Cashews',
                        'Jamun & Avocado' => 'Jamun & Avocado',
                        'Natural Fruit-processed Products- Mango ,Pulp' => 'Natural Fruit-processed Products- Mango ,Pulp',
                        'Spices, Pickles, Sweet Preserves' => 'Spices, Pickles, Sweet Preserves',
                    ]),
                Tables\Filters\Filter::make('is_active')
                    ->label('Active products')
                    ->query(fn (Builder $query): Builder => $query->where('is_active', true)),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}