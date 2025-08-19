<?php
// app/Filament/Resources/TestimonialResource.php

namespace App\Filament\Resources;

use App\Filament\Resources\TestimonialResource\Pages;
use App\Filament\Resources\TestimonialResource\RelationManagers;
use App\Models\Testimonial;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TestimonialResource extends Resource
{
    protected static ?string $model = Testimonial::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Testimonial')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('English')
                            ->schema([
                                Forms\Components\TextInput::make('name.en')
                                    ->label('Name (English)')
                                    ->required(),
                                Forms\Components\TextInput::make('role.en')
                                    ->label('Role (English)')
                                    ->required(),
                                Forms\Components\TextInput::make('location.en')
                                    ->label('Location (English)')
                                    ->required(),
                                Forms\Components\Textarea::make('content.en')
                                    ->label('Content (English)')
                                    ->required()
                                    ->rows(3),
                            ]),
                        Forms\Components\Tabs\Tab::make('Marathi')
                            ->schema([
                                Forms\Components\TextInput::make('name.mr')
                                    ->label('Name (Marathi)')
                                    ->required(),
                                Forms\Components\TextInput::make('role.mr')
                                    ->label('Role (Marathi)')
                                    ->required(),
                                Forms\Components\TextInput::make('location.mr')
                                    ->label('Location (Marathi)')
                                    ->required(),
                                Forms\Components\Textarea::make('content.mr')
                                    ->label('Content (Marathi)')
                                    ->required()
                                    ->rows(3),
                            ]),
                    ]),
                Forms\Components\Select::make('rating')
                    ->options([
                        1 => '1 Star',
                        2 => '2 Stars',
                        3 => '3 Stars',
                        4 => '4 Stars',
                        5 => '5 Stars',
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
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->formatStateUsing(fn ($state) => $state['en'] ?? '')
                    ->label('Name'),
                Tables\Columns\TextColumn::make('role')
                    ->formatStateUsing(fn ($state) => $state['en'] ?? '')
                    ->label('Role'),
                Tables\Columns\TextColumn::make('rating')
                    ->badge()
                    ->color(fn (int $state): string => match (true) {
                        $state >= 4 => 'success',
                        $state === 3 => 'warning',
                        default => 'danger',
                    }),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('sort_order'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
            ])
            ->filters([
                Tables\Filters\Filter::make('is_active')
                    ->query(fn (Builder $query): Builder => $query->where('is_active', true)),
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
            'index' => Pages\ListTestimonials::route('/'),
            'create' => Pages\CreateTestimonial::route('/create'),
            'edit' => Pages\EditTestimonial::route('/{record}/edit'),
        ];
    }
}