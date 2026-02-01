<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CareerChallengeResource\Pages;
use App\Models\CareerChallenge;
use App\Models\Club;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CareerChallengeResource extends Resource
{
    protected static ?string $model = CareerChallenge::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';

    protected static ?string $navigationGroup = 'Games';

    protected static ?string $navigationLabel = 'Career Challenge';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('game_id')
                    ->default(\App\Models\Game::where('slug', 'career')->first()?->id ?? 1),
                
                Forms\Components\Section::make('Player Information')
                    ->schema([
                        Forms\Components\TextInput::make('player_name')
                            ->label('Player Name (Answer)')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g., Cristiano Ronaldo')
                            ->columnSpanFull(),
                        Forms\Components\FileUpload::make('player_image')
                            ->label('Player Image (Optional)')
                            ->image()
                            ->directory('career-players')
                            ->disk('public')
                            ->visibility('public'),
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

                Forms\Components\Section::make('Career Chain')
                    ->description('Add clubs in chronological order to form the career path')
                    ->schema([
                        Forms\Components\Repeater::make('careerClubs')
                            ->relationship('careerClubs')
                            ->schema([
                                Forms\Components\Select::make('club_id')
                                    ->label('Club')
                                    ->options(Club::all()->pluck('name', 'id'))
                                    ->searchable()
                                    ->preload()
                                    ->required()
                                    ->columnSpan(2),
                                Forms\Components\TextInput::make('join_year')
                                    ->label('Join Year')
                                    ->numeric()
                                    ->minValue(1900)
                                    ->maxValue(2030)
                                    ->required()
                                    ->placeholder('e.g., 2009'),
                                Forms\Components\Hidden::make('sort_order')
                                    ->default(0),
                            ])
                            ->columns(3)
                            ->orderColumn('sort_order')
                            ->reorderableWithButtons()
                            ->collapsible()
                            ->defaultItems(2)
                            ->minItems(2)
                            ->addActionLabel('Add Club')
                            ->itemLabel(fn (array $state): ?string =>
                                isset($state['club_id'])
                                    ? Club::find($state['club_id'])?->name . ' (' . ($state['join_year'] ?? '?') . ')'
                                    : null
                            )
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Hints')
                    ->schema([
                        Forms\Components\Repeater::make('hints')
                            ->relationship('hints')
                            ->schema([
                                Forms\Components\Textarea::make('content')
                                    ->label('Hint')
                                    ->required()
                                    ->rows(2)
                                    ->columnSpanFull(),
                                Forms\Components\TextInput::make('sort_order')
                                    ->numeric()
                                    ->default(0)
                                    ->label('Order'),
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
                Tables\Columns\TextColumn::make('player_name')
                    ->label('Player (Answer)')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('career_path_description')
                    ->label('Career Path')
                    ->wrap()
                    ->limit(60),
                Tables\Columns\TextColumn::make('careerClubs_count')
                    ->label('Clubs')
                    ->counts('careerClubs')
                    ->badge()
                    ->color('info'),
                Tables\Columns\TextColumn::make('hints_count')
                    ->label('Hints')
                    ->counts('hints')
                    ->badge()
                    ->color('warning'),
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
            'index' => Pages\ListCareerChallenges::route('/'),
            'create' => Pages\CreateCareerChallenge::route('/create'),
            'edit' => Pages\EditCareerChallenge::route('/{record}/edit'),
        ];
    }
}
