<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClubResource\Pages;
use App\Models\Club;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ClubResource extends Resource
{
    protected static ?string $model = Club::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-library';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('club_id')
                    ->required()
                    ->numeric()
                    ->disabled(fn ($record) => $record !== null),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('domestic_competition_id')
                    ->label('Competition ID (League)')
                    ->maxLength(50),
                Forms\Components\TextInput::make('coach_name')
                    ->maxLength(255),
                Forms\Components\TextInput::make('stadium_name')
                    ->maxLength(255),
                Forms\Components\TextInput::make('stadium_seats')
                    ->numeric(),
                Forms\Components\TextInput::make('total_market_value')
                    ->maxLength(100),
                Forms\Components\TextInput::make('url')
                    ->url()
                    ->maxLength(500)
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('club_id')
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('domestic_competition_id')
                    ->label('League')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('coach_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('stadium_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('total_market_value')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('domestic_competition_id')
                    ->label('League')
                    ->options(fn () => Club::distinct()->whereNotNull('domestic_competition_id')->pluck('domestic_competition_id', 'domestic_competition_id')->toArray()),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('name');
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
            'index' => Pages\ListClubs::route('/'),
            'create' => Pages\CreateClub::route('/create'),
            'edit' => Pages\EditClub::route('/{record}/edit'),
        ];
    }
}
