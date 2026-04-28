<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ChallengeResource\Pages;
use App\Models\Challenge;
use App\Models\Game;
use App\Models\Genre;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ChallengeResource extends Resource
{
    protected static ?string $model = Challenge::class;
    protected static ?string $navigationIcon = 'heroicon-o-puzzle-piece';
    protected static ?string $navigationGroup = 'Games';
    protected static ?string $navigationLabel = 'All Challenges';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Challenge Setup')
                    ->schema([
                        Forms\Components\Select::make('game_id')
                            ->label('Game')
                            ->options(Game::whereNotNull('game_type')->pluck('title', 'id'))
                            ->required()
                            ->live()
                            ->afterStateUpdated(fn (callable $set) => $set('stimulus_data', null)),
                        Forms\Components\Select::make('genre_id')
                            ->label('Genre')
                            ->options(Genre::pluck('name_en', 'id'))
                            ->required(),
                        Forms\Components\Select::make('difficulty')
                            ->options([
                                'easy' => 'Easy',
                                'medium' => 'Medium',
                                'hard' => 'Hard',
                            ])
                            ->default('medium')
                            ->required(),
                        Forms\Components\Select::make('stimulus_type')
                            ->options([
                                'image' => 'Image',
                                'video' => 'Video',
                                'text' => 'Text',
                                'scrambled_text' => 'Scrambled Text',
                                'sequence' => 'Sequence',
                            ])
                            ->default('text')
                            ->required()
                            ->live(),
                        Forms\Components\Select::make('answer_type')
                            ->label('Autocomplete Type')
                            ->options([
                                'player' => 'Players',
                                'club' => 'Clubs',
                                'stadium' => 'Stadiums',
                                'none' => 'None / Generic',
                            ])
                            ->default('player'),
                        Forms\Components\Toggle::make('is_active')
                            ->default(true),
                    ])->columns(3),

                // ── Answer Section ──
                Forms\Components\Section::make('Answer')
                    ->schema([
                        Forms\Components\TextInput::make('answer')
                            ->label('Primary Answer')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TagsInput::make('answers')
                            ->label('Multiple Valid Answers (for Transfer Chain / Group)')
                            ->helperText('Add multiple acceptable answers'),
                    ])->columns(2),

                // ── Dynamic Stimulus Data Section ──
                Forms\Components\Section::make('Stimulus Data')
                    ->schema([
                        // Image fields (Stadium, Kit, Silhouette)
                        Forms\Components\FileUpload::make('stimulus_data.image_path')
                            ->label('Challenge Image')
                            ->directory('challenges')
                            ->image()
                            ->visibility('public')
                            ->visible(fn (Get $get) => in_array($get('stimulus_type'), ['image'])),

                        Forms\Components\FileUpload::make('stimulus_data.full_image_path')
                            ->label('Reveal Image (Full)')
                            ->directory('challenges/reveals')
                            ->image()
                            ->visibility('public')
                            ->visible(fn (Get $get) => $get('stimulus_type') === 'image'),

                        // Video fields
                        Forms\Components\TextInput::make('stimulus_data.youtube_url')
                            ->label('YouTube URL')
                            ->url()
                            ->visible(fn (Get $get) => $get('stimulus_type') === 'video'),
                        Forms\Components\TextInput::make('stimulus_data.question')
                            ->label('Question')
                            ->visible(fn (Get $get) => in_array($get('stimulus_type'), ['video', 'text'])),
                        Forms\Components\TextInput::make('stimulus_data.start_time')
                            ->label('Start Time')
                            ->visible(fn (Get $get) => $get('stimulus_type') === 'video'),
                        Forms\Components\TextInput::make('stimulus_data.end_time')
                            ->label('End Time')
                            ->visible(fn (Get $get) => $get('stimulus_type') === 'video'),

                        // Text/Clue fields (Glossary)
                        Forms\Components\Textarea::make('stimulus_data.clue')
                            ->label('Clue / Description')
                            ->visible(fn (Get $get) => $get('stimulus_type') === 'text'),

                        // Scrambled text fields (Anagram)
                        Forms\Components\TextInput::make('stimulus_data.scrambled_word')
                            ->label('Scrambled Word')
                            ->visible(fn (Get $get) => $get('stimulus_type') === 'scrambled_text'),
                        Forms\Components\TextInput::make('stimulus_data.category')
                            ->label('Word Category (e.g., player, team, stadium)')
                            ->visible(fn (Get $get) => $get('stimulus_type') === 'scrambled_text'),

                        // Missing Link
                        Forms\Components\TextInput::make('stimulus_data.part_a')
                            ->label('Part A')
                            ->visible(fn (Get $get) => $get('stimulus_type') === 'text'),
                        Forms\Components\TextInput::make('stimulus_data.part_b')
                            ->label('Part B')
                            ->visible(fn (Get $get) => $get('stimulus_type') === 'text'),

                        // Transfer Chain
                        Forms\Components\TextInput::make('stimulus_data.club_a')
                            ->label('Club A')
                            ->visible(fn (Get $get) => $get('stimulus_type') === 'text'),
                        Forms\Components\TextInput::make('stimulus_data.club_b')
                            ->label('Club B')
                            ->visible(fn (Get $get) => $get('stimulus_type') === 'text'),

                        // Stadium metadata
                        Forms\Components\TextInput::make('stimulus_data.capacity')
                            ->label('Capacity')
                            ->numeric()
                            ->visible(fn (Get $get) => $get('stimulus_type') === 'image'),
                        Forms\Components\TextInput::make('stimulus_data.country')
                            ->label('Country')
                            ->visible(fn (Get $get) => $get('stimulus_type') === 'image'),
                        Forms\Components\TextInput::make('stimulus_data.opened_year')
                            ->label('Opened Year')
                            ->numeric()
                            ->visible(fn (Get $get) => $get('stimulus_type') === 'image'),

                        // Group challenge
                        Forms\Components\TextInput::make('stimulus_data.title')
                            ->label('Group Title')
                            ->visible(fn (Get $get) => $get('stimulus_type') === 'text'),

                    ])->columns(2),

                // ── Hints ──
                Forms\Components\Section::make('Hints')
                    ->schema([
                        Forms\Components\Repeater::make('hints')
                            ->relationship('hints')
                            ->schema([
                                Forms\Components\Textarea::make('content')
                                    ->required()
                                    ->rows(2),
                                Forms\Components\Hidden::make('sort_order')
                                    ->default(0),
                            ])
                            ->orderColumn('sort_order')
                            ->addActionLabel('Add Hint')
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('game.title')
                    ->label('Game')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('genre.name_en')
                    ->label('Genre')
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('answer')
                    ->label('Answer')
                    ->searchable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('difficulty')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'easy' => 'success',
                        'medium' => 'warning',
                        'hard' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('stimulus_type')
                    ->badge(),
                Tables\Columns\TextColumn::make('answer_type')
                    ->label('Autocomplete')
                    ->badge()
                    ->color('info'),
                Tables\Columns\TextColumn::make('hints_count')
                    ->counts('hints')
                    ->label('Hints'),
                Tables\Columns\ToggleColumn::make('is_active'),
            ])
            ->defaultSort('game_id')
            ->filters([
                Tables\Filters\SelectFilter::make('game_id')
                    ->label('Game')
                    ->options(Game::whereNotNull('game_type')->pluck('title', 'id')),
                Tables\Filters\SelectFilter::make('genre_id')
                    ->label('Genre')
                    ->options(Genre::pluck('name_en', 'id')),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListChallenges::route('/'),
            'create' => Pages\CreateChallenge::route('/create'),
            'edit' => Pages\EditChallenge::route('/{record}/edit'),
        ];
    }
}
