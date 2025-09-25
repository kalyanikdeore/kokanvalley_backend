<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GuestExperienceResource\Pages;
use App\Filament\Resources\GuestExperienceResource\RelationManagers;
use App\Models\GuestExperience;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GuestExperienceResource extends Resource
{
    protected static ?string $model = GuestExperience::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
     protected static ?string $navigationGroup = 'Gallery page';
    protected static ?string $navigationLabel = 'Guest Experience';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('image')
                    ->image()
                    ->required()
                    ->directory('guest-experiences')
                    ->disk('public') // Use the public disk (now pointing to uploads)
                    ->visibility('public'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->disk('public') // Read from public disk (uploads)
                    ->size(100),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                //
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
            'index' => Pages\ListGuestExperiences::route('/'),
            'create' => Pages\CreateGuestExperience::route('/create'),
            'edit' => Pages\EditGuestExperience::route('/{record}/edit'),
        ];
    }
}