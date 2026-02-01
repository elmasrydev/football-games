<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KitChallengeResource\Pages;
use App\Models\KitChallenge;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class KitChallengeResource extends Resource
{
    protected static ?string $model = KitChallenge::class;

    protected static ?string $navigationIcon = 'heroicon-o-swatch';

    protected static ?string $navigationGroup = 'Games';

    protected static ?string $navigationLabel = 'Kit Detective';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('game_id')
                    ->default(\App\Models\Game::where('slug', 'kit-detective')->first()?->id ?? 1),
                
                Forms\Components\Section::make('Kit Images')
                    ->schema([
                        Forms\Components\FileUpload::make('image_path')
                            ->label('Zoomed-in Detail (Challenge)')
                            ->image()
                            ->directory('kits/zoomed')
                            ->disk('public')
                            ->required(),
                        Forms\Components\FileUpload::make('full_image_path')
                            ->label('Full Kit (Reveal)')
                            ->image()
                            ->directory('kits/full')
                            ->disk('public'),
                    ])->columns(2),

                Forms\Components\Section::make('Answer Details')
                    ->schema([
                        Forms\Components\TextInput::make('team_name')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g., Real Madrid'),
                        Forms\Components\TextInput::make('kit_year')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('e.g., 2011-12'),
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
                    ])->columns(3),

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
                    ->label('Detail')
                    ->disk('public'),
                Tables\Columns\TextColumn::make('team_name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kit_year')
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
            'index' => Pages\ListKitChallenges::route('/'),
            'create' => Pages\CreateKitChallenge::route('/create'),
            'edit' => Pages\EditKitChallenge::route('/{record}/edit'),
        ];
    }
}
