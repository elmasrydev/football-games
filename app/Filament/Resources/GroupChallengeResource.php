<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GroupChallengeResource\Pages;
use App\Filament\Resources\GroupChallengeResource\RelationManagers;
use App\Models\GroupChallenge;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GroupChallengeResource extends Resource
{
    protected static ?string $model = GroupChallenge::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Games';

    protected static ?string $navigationLabel = 'Group Challenge';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('game_id')
                    ->default(\App\Models\Game::where('slug', 'group-players')->first()?->id ?? 1),

                Forms\Components\Section::make('Challenge Information')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\FileUpload::make('image')
                            ->image()
                            ->directory('group-challenges')
                            ->required(),
                        Forms\Components\TextInput::make('players_count')
                            ->label('Number of Players')
                            ->numeric()
                            ->default(1)
                            ->minValue(1)
                            ->maxValue(22)
                            ->required()
                            ->live(),
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
                    ])
                    ->columns(2),

                Forms\Components\Section::make('Players')
                    ->description('Add player names in the order they should appear in the covered slots')
                    ->schema([
                        Forms\Components\Repeater::make('players')
                            ->relationship('players')
                            ->schema([
                                Forms\Components\Select::make('player_name')
                                    ->label('Player Name')
                                    ->searchable()
                                    ->getSearchResultsUsing(fn (string $search): array => \App\Models\Player::where('name', 'like', "%{$search}%")->limit(20)->pluck('name', 'name')->toArray())
                                    ->getOptionLabelUsing(fn ($value): ?string => $value)
                                    ->required()
                                    ->columnSpanFull(),
                                Forms\Components\Hidden::make('sort_order')
                                    ->default(0),
                            ])
                            ->orderColumn('sort_order')
                            ->reorderableWithButtons()
                            ->collapsible()
                            ->minItems(fn (Forms\Get $get) => (int) $get('players_count'))
                            ->maxItems(fn (Forms\Get $get) => (int) $get('players_count'))
                            ->addActionLabel('Add Player')
                            ->itemLabel(fn (array $state): ?string => $state['player_name'] ?? 'New Player')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Hints')
                    ->schema([
                        Forms\Components\Repeater::make('hints')
                            ->relationship('hints')
                            ->schema([
                                Forms\Components\Textarea::make('content')
                                    ->label('Hint Content')
                                    ->required()
                                    ->rows(2)
                                    ->columnSpanFull(),
                                Forms\Components\Hidden::make('sort_order')
                                    ->default(0),
                            ])
                            ->orderColumn('sort_order')
                            ->reorderableWithButtons()
                            ->collapsible()
                            ->addActionLabel('Add Hint')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\TextColumn::make('players_count')
                    ->label('N')
                    ->badge()
                    ->color('info'),
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
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('difficulty')
                    ->options([
                        'easy' => 'Easy',
                        'medium' => 'Medium',
                        'hard' => 'Hard',
                    ]),
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
            'index' => Pages\ListGroupChallenges::route('/'),
            'create' => Pages\CreateGroupChallenge::route('/create'),
            'edit' => Pages\EditGroupChallenge::route('/{record}/edit'),
        ];
    }
}
