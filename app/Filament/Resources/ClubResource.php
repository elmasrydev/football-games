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
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('logo_url')
                    ->label('Logo URL')
                    ->url()
                    ->maxLength(500)
                    ->placeholder('https://example.com/logo.svg')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('country')
                    ->required()
                    ->maxLength(100),
                Forms\Components\Select::make('league')
                    ->options([
                        'Premier League' => 'Premier League (England)',
                        'La Liga' => 'La Liga (Spain)',
                        'Bundesliga' => 'Bundesliga (Germany)',
                        'Serie A' => 'Serie A (Italy)',
                        'Ligue 1' => 'Ligue 1 (France)',
                        'Primeira Liga' => 'Primeira Liga (Portugal)',
                        'Eredivisie' => 'Eredivisie (Netherlands)',
                        'Saudi Pro League' => 'Saudi Pro League',
                        'MLS' => 'MLS (USA)',
                        'Scottish Premiership' => 'Scottish Premiership',
                        'Super Lig' => 'Super Lig (Turkey)',
                        'Brasileirao' => 'Brasileirao (Brazil)',
                        'Primera Division' => 'Primera Division (Argentina)',
                        'Other' => 'Other',
                    ])
                    ->searchable()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('logo_url')
                    ->label('Logo')
                    ->circular()
                    ->size(40),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('country')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('league')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Premier League' => 'danger',
                        'La Liga' => 'warning',
                        'Bundesliga' => 'success',
                        'Serie A' => 'info',
                        'Ligue 1' => 'primary',
                        default => 'gray',
                    })
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('league')
                    ->options([
                        'Premier League' => 'Premier League',
                        'La Liga' => 'La Liga',
                        'Bundesliga' => 'Bundesliga',
                        'Serie A' => 'Serie A',
                        'Ligue 1' => 'Ligue 1',
                        'Saudi Pro League' => 'Saudi Pro League',
                        'Primeira Liga' => 'Primeira Liga',
                        'Eredivisie' => 'Eredivisie',
                        'MLS' => 'MLS',
                    ]),
                Tables\Filters\SelectFilter::make('country')
                    ->options(fn () => Club::distinct()->pluck('country', 'country')->toArray()),
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
