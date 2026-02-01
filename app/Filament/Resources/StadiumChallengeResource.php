<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StadiumChallengeResource\Pages;
use App\Filament\Resources\StadiumChallengeResource\RelationManagers;
use App\Models\StadiumChallenge;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class StadiumChallengeResource extends Resource
{
    protected static ?string $model = StadiumChallenge::class;

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';

    protected static ?string $navigationGroup = 'Games';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('game_id')
                    ->default(\App\Models\Game::where('slug', 'stadium-spotter')->first()?->id ?? 1),
                Forms\Components\FileUpload::make('image_path')
                    ->label('Stadium Image')
                    ->image()
                    ->directory('stadiums')
                    ->disk('public')
                    ->visibility('public')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('stadium_name')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('capacity')
                    ->numeric()
                    ->helperText('Stadium capacity (e.g., 99,354)'),
                Forms\Components\TextInput::make('opened_year')
                    ->numeric()
                    ->helperText('Year stadium opened (e.g., 1957)'),
                Forms\Components\TextInput::make('country')
                    ->maxLength(255)
                    ->helperText('Country where stadium is located'),
                Forms\Components\Select::make('difficulty')
                    ->options([
                        'easy' => 'Easy',
                        'medium' => 'Medium',
                        'hard' => 'Hard',
                    ])
                    ->default('medium')
                    ->required(),
                Forms\Components\Toggle::make('is_active')
                    ->label('Active')
                    ->default(true),
                Forms\Components\Section::make('Hints')
                    ->schema([
                        Forms\Components\Repeater::make('hints')
                            ->relationship('hints')
                            ->schema([
                                Forms\Components\Textarea::make('content')
                                    ->required()
                                    ->columnSpanFull(),
                                Forms\Components\TextInput::make('sort_order')
                                    ->numeric()
                                    ->default(0),
                            ])
                            ->orderColumn('sort_order')
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('game.title')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\ImageColumn::make('image_path')
                    ->disk('public'),
                Tables\Columns\TextColumn::make('stadium_name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('capacity')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('opened_year')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('country')
                    ->searchable(),
                Tables\Columns\TextColumn::make('difficulty')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'easy' => 'success',
                        'medium' => 'warning',
                        'hard' => 'danger',
                    }),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Active'),
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
            'index' => Pages\ListStadiumChallenges::route('/'),
            'create' => Pages\CreateStadiumChallenge::route('/create'),
            'edit' => Pages\EditStadiumChallenge::route('/{record}/edit'),
        ];
    }
}
