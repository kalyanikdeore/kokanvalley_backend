<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientTestimonialResource\Pages;
use App\Filament\Resources\ClientTestimonialResource\RelationManagers;
use App\Models\ClientTestimonial;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ClientTestimonialResource extends Resource
{
    protected static ?string $model = ClientTestimonial::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    protected static ?string $navigationGroup = 'Content Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Testimonial Details')
                    ->schema([
                        Forms\Components\TextInput::make('name.en')
                            ->label('Name (English)')
                            ->required(),
                        Forms\Components\TextInput::make('name.mr')
                            ->label('Name (Marathi)')
                            ->required(),
                        Forms\Components\TextInput::make('role.en')
                            ->label('Role (English)')
                            ->required(),
                        Forms\Components\TextInput::make('role.mr')
                            ->label('Role (Marathi)')
                            ->required(),
                        Forms\Components\TextInput::make('location.en')
                            ->label('Location (English)')
                            ->required(),
                        Forms\Components\TextInput::make('location.mr')
                            ->label('Location (Marathi)')
                            ->required(),
                        Forms\Components\Textarea::make('content.en')
                            ->label('Content (English)')
                            ->required()
                            ->rows(3),
                        Forms\Components\Textarea::make('content.mr')
                            ->label('Content (Marathi)')
                            ->required()
                            ->rows(3),
                        Forms\Components\Select::make('rating')
                            ->options([
                                1 => 1,
                                2 => 2,
                                3 => 3,
                                4 => 4,
                                5 => 5,
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('project_id')
                            ->numeric()
                            ->required(),
                        Forms\Components\TextInput::make('sort_order')
                            ->numeric()
                            ->default(0),
                        Forms\Components\Toggle::make('is_active')
                            ->default(true),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->formatStateUsing(fn ($state) => $state['en'] ?? '')
                    ->searchable(['name->en', 'name->mr']),
                Tables\Columns\TextColumn::make('role')
                    ->formatStateUsing(fn ($state) => $state['en'] ?? ''),
                Tables\Columns\TextColumn::make('rating')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('sort_order')
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
                Tables\Filters\Filter::make('is_active')
                    ->query(fn (Builder $query) => $query->where('is_active', true)),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListClientTestimonials::route('/'),
            'create' => Pages\CreateClientTestimonial::route('/create'),
            'edit' => Pages\EditClientTestimonial::route('/{record}/edit'),
        ];
    }
}