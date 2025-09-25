<?php
namespace App\Filament\Resources;

use App\Filament\Resources\AmenitiesSectionResource\Pages;
use App\Models\AmenitiesSection;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;  

class AmenitiesSectionResource extends Resource
{
    protected static ?string $model = AmenitiesSection::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Gallery page';
    protected static ?string $navigationLabel = 'Amenities Section';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
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
                    ->rows(3),

                Forms\Components\Textarea::make('description_mr')
                    ->label('Description (Marathi)')
                    ->rows(3),

                Forms\Components\TextInput::make('icon')
                    ->label('Icon Name (pool, bed, utensils, nature)')
                    ->maxLength(50),

                Forms\Components\FileUpload::make('images')
                    ->label('Images')
                    ->multiple()
                    ->image()
                    ->directory('amenities-images/uploads') // Changed to nested directory
                    ->reorderable()
                    ->maxFiles(10),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')->sortable(),
                Tables\Columns\TextColumn::make('title_en')->label('Title EN')->searchable(),
                Tables\Columns\TextColumn::make('title_mr')->label('Title MR')->searchable(),
                Tables\Columns\TextColumn::make('icon')->sortable(),
                Tables\Columns\ImageColumn::make('images')
                    ->circular()
                    ->stacked()
                    ->limit(2)
                    ->size(40),
                Tables\Columns\TextColumn::make('created_at')->dateTime(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListAmenitiesSections::route('/'),
            'create' => Pages\CreateAmenitiesSection::route('/create'),
            'edit'   => Pages\EditAmenitiesSection::route('/{record}/edit'),
        ];
    }
}