<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GameItemResource\Pages;
use App\Models\GameItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;

class GameItemResource extends Resource
{
    protected static ?string $model = GameItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    
    protected static ?string $navigationGroup = 'Game Data';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Basic Information')
                    ->schema([
                        Forms\Components\Select::make('type')
                            ->options([
                                'player' => 'Player',
                                'club' => 'Club',
                                'stadium' => 'Stadium',
                                'actor' => 'Actor',
                                'movie' => 'Movie',
                                'manager' => 'Manager',
                                'country' => 'Country',
                                'competition' => 'Competition',
                            ])
                            ->required()
                            ->searchable(),
                        Forms\Components\TextInput::make('name_en')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('name_ar')
                            ->maxLength(255),
                        Forms\Components\TextInput::make('country')
                            ->maxLength(100),
                    ])->columns(2),

                Forms\Components\Section::make('Media & Metadata')
                    ->schema([
                        SpatieMediaLibraryFileUpload::make('image')
                            ->collection('image')
                            ->image()
                            ->imageEditor(),
                        Forms\Components\KeyValue::make('metadata')
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('external_id')
                            ->label('External ID (Legacy)')
                            ->disabled()
                            ->helperText('Original ID from source data.'),
                        Forms\Components\Toggle::make('is_active')
                            ->default(true)
                            ->required(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('image')
                    ->collection('image')
                    ->circular(),
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'player' => 'info',
                        'club' => 'success',
                        'stadium' => 'warning',
                        'movie' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('name_en')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name_ar')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('country')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'player' => 'Player',
                        'club' => 'Club',
                        'stadium' => 'Stadium',
                        'actor' => 'Actor',
                        'movie' => 'Movie',
                    ]),
                Tables\Filters\TernaryFilter::make('is_active'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGameItems::route('/'),
            'create' => Pages\CreateGameItem::route('/create'),
            'view' => Pages\ViewGameItem::route('/{record}'),
            'edit' => Pages\EditGameItem::route('/{record}/edit'),
        ];
    }
}
