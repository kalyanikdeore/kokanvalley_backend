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

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('image')
                    ->image()
                    ->required()
                    ->directory('guest-experiences') // Store in guest-experiences directory
                    ->visibility('public'), // Make files publicly accessible
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->disk('public'), // Read from public disk
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