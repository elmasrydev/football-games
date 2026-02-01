<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SilhouetteChallengeResource\Pages;
use App\Models\SilhouetteChallenge;
use App\Models\Game;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SilhouetteChallengeResource extends Resource
{
    protected static ?string $model = SilhouetteChallenge::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $navigationGroup = 'Games';

    protected static ?string $navigationLabel = 'Guess Silhouette';

    protected static ?string $modelLabel = 'Silhouette Challenge';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('game_id')
                    ->default(fn () => Game::where('slug', 'guess-silhouette')->first()?->id),

                Forms\Components\Section::make('Images')
                    ->schema([
                        Forms\Components\FileUpload::make('image_path')
                            ->label('Silhouette Image')
                            ->image()
                            ->directory('silhouettes')
                            ->disk('public')
                            ->required(),
                        Forms\Components\FileUpload::make('reveal_image_path')
                            ->label('Reveal Image (optional)')
                            ->image()
                            ->directory('silhouettes/reveals')
                            ->disk('public')
                            ->helperText('Full player image shown after correct answer'),
                    ])->columns(2),

                Forms\Components\Section::make('Answer Details')
                    ->schema([
                        Forms\Components\TextInput::make('player_name')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g., Cristiano Ronaldo'),
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
                    ])->columns(2),

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
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_path')
                    ->label('Silhouette')
                    ->disk('public')
                    ->size(60),
                Tables\Columns\TextColumn::make('player_name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('difficulty')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'easy' => 'success',
                        'medium' => 'warning',
                        'hard' => 'danger',
                    }),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Active'),
                Tables\Columns\TextColumn::make('hints_count')
                    ->counts('hints')
                    ->label('Hints'),
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
            'index' => Pages\ListSilhouetteChallenges::route('/'),
            'create' => Pages\CreateSilhouetteChallenge::route('/create'),
            'edit' => Pages\EditSilhouetteChallenge::route('/{record}/edit'),
        ];
    }
}
