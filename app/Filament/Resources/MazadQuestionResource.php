<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MazadQuestionResource\Pages;
use App\Models\MazadQuestion;
use App\Models\GameItem;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MazadQuestionResource extends Resource
{
    protected static ?string $model = MazadQuestion::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-bottom-center-text';

    protected static ?string $navigationGroup = 'Games';
    
    protected static ?string $navigationLabel = 'Mazad Questions';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Question Setup')
                    ->schema([
                        Forms\Components\TextInput::make('text')
                            ->label('Question Text (English)')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('text_ar')
                            ->label('Question Text (Arabic)')
                            ->maxLength(255),
                        Forms\Components\Select::make('category')
                            ->options([
                                'football' => 'Football',
                                'entertainment' => 'Entertainment',
                                'cinema' => 'Cinema',
                                'geography' => 'Geography',
                                'sports' => 'Sports',
                                'food' => 'Food',
                                'history' => 'History',
                                'music' => 'Music',
                                'science' => 'Science',
                                'language' => 'Language',
                                'animals' => 'Animals',
                                'general' => 'General',
                            ])
                            ->required(),
                        Forms\Components\Select::make('difficulty')
                            ->options([
                                'easy' => 'Easy',
                                'medium' => 'Medium',
                                'hard' => 'Hard',
                            ])
                            ->default('medium')
                            ->required(),
                    ])->columns(2),

                Forms\Components\Section::make('Accepted Answers')
                    ->schema([
                        Forms\Components\Select::make('accepted_answers')
                            ->label('Accepted Answers (Game Items)')
                            ->multiple()
                            ->searchable()
                            ->getSearchResultsUsing(fn (string $search): array => GameItem::where('name_en', 'like', "%{$search}%")
                                ->orWhere('name_ar', 'like', "%{$search}%")
                                ->limit(50)
                                ->pluck('name_en', 'id')
                                ->toArray())
                            ->getOptionLabelsUsing(fn (array $values): array => GameItem::whereIn('id', $values)
                                ->pluck('name_en', 'id')
                                ->toArray())
                            ->required()
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('text')
                    ->label('English Text')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('text_ar')
                    ->label('Arabic Text')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category')
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('difficulty')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'easy' => 'success',
                        'medium' => 'warning',
                        'hard' => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('accepted_answers')
                    ->label('Answers Count')
                    ->state(fn (MazadQuestion $record): int => count($record->accepted_answers ?? [])),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->options([
                        'football' => 'Football',
                        'entertainment' => 'Entertainment',
                        'cinema' => 'Cinema',
                        'geography' => 'Geography',
                        'sports' => 'Sports',
                        'food' => 'Food',
                        'history' => 'History',
                        'music' => 'Music',
                        'science' => 'Science',
                        'language' => 'Language',
                        'animals' => 'Animals',
                        'general' => 'General',
                    ]),
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
            'index' => Pages\ListMazadQuestions::route('/'),
            'create' => Pages\CreateMazadQuestion::route('/create'),
            'edit' => Pages\EditMazadQuestion::route('/{record}/edit'),
        ];
    }
}
