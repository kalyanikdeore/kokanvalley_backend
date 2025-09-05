<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactInformationResource\Pages;
use App\Filament\Resources\ContactInformationResource\RelationManagers;
use App\Models\ContactInformation;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContactInformationResource extends Resource
{
    protected static ?string $model = ContactInformation::class;

    protected static ?string $navigationIcon = 'heroicon-o-phone';

    protected static ?string $navigationLabel = 'Contact Information';

    protected static ?string $modelLabel = 'Contact Information';

    protected static ?string $pluralModelLabel = 'Contact Information';

    // Make it a singleton resource (only one record)
    // public static function canCreate(): bool
    // {
    //     return false;
    // }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('phone_number')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\Repeater::make('addresses')
                    ->schema([
                        Forms\Components\TextInput::make('line1_en')
                            ->label('Address Line 1 (English)')
                            ->required(),
                        Forms\Components\TextInput::make('line1_mr')
                            ->label('Address Line 1 (Marathi)')
                            ->required(),
                        Forms\Components\TextInput::make('line2_en')
                            ->label('Address Line 2 (English)')
                            ->required(),
                        Forms\Components\TextInput::make('line2_mr')
                            ->label('Address Line 2 (Marathi)')
                            ->required(),
                    ])
                    ->defaultItems(2)
                    ->minItems(1)
                    ->maxItems(5),
                Forms\Components\Section::make('Social Links')
                    ->schema([
                        Forms\Components\TextInput::make('social_links.facebook')
                            ->label('Facebook URL')
                            ->url(),
                        Forms\Components\TextInput::make('social_links.instagram')
                            ->label('Instagram URL')
                            ->url(),
                        Forms\Components\TextInput::make('social_links.twitter')
                            ->label('Twitter URL')
                            ->url(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('phone_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
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
            'index' => Pages\ListContactInformation::route('/'),
            'create' => Pages\CreateContactInformation::route('/create'),
            'edit' => Pages\EditContactInformation::route('/{record}/edit'),
        ];
    }
}