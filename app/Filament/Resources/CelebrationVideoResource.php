<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CelebrationVideoResource\Pages;
use App\Models\Video;
use App\Models\Game;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CelebrationVideoResource extends Resource
{
    protected static ?string $model = Video::class;

    protected static ?string $navigationIcon = 'heroicon-o-sparkles';

    protected static ?string $navigationGroup = 'Games';

    protected static ?string $navigationLabel = 'Highlight Moments';

    protected static ?string $modelLabel = 'Highlight Moment';

    protected static ?string $slug = 'highlight-moments-videos';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereHas('game', fn ($q) => $q->where('slug', 'highlight-moments'));
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('game_id')
                    ->default(fn () => Game::where('slug', 'highlight-moments')->first()?->id),
                Forms\Components\TextInput::make('youtube_url')
                    ->live(onBlur: true),
                Forms\Components\FileUpload::make('uploaded_video')
                    ->directory('videos')
                    ->visibility('public')
                    ->live(),
                Forms\Components\Placeholder::make('video_preview')
                    ->columnSpanFull()
                    ->content(fn ($get) => view('filament.components.video-preview', [
                        'youtube_url' => $get('youtube_url'),
                        'uploaded_video' => $get('uploaded_video'),
                    ])),
                Forms\Components\TextInput::make('start_time')
                    ->label('Start Time')
                    ->placeholder('e.g. 0:15')
                    ->helperText('Format: MM:SS or seconds'),
                Forms\Components\TextInput::make('end_time')
                    ->label('End Time')
                    ->placeholder('e.g. 0:25')
                    ->helperText('Format: MM:SS or seconds'),
                Forms\Components\Textarea::make('question')
                    ->required()
                    ->placeholder('e.g. Which player is known for this celebration?')
                    ->columnSpanFull(),
                Forms\Components\Select::make('answer')
                    ->label('Answer')
                    ->searchable()
                    ->getSearchResultsUsing(fn (string $search): array => \App\Models\Player::where('name', 'like', "%{$search}%")->limit(20)->pluck('name', 'name')->toArray())
                    ->getOptionLabelUsing(fn ($value): ?string => $value)
                    ->required()
                    ->placeholder('e.g. Cristiano Ronaldo'),
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
                Tables\Columns\TextColumn::make('youtube_url')
                    ->searchable()
                    ->limit(30),
                Tables\Columns\TextColumn::make('answer')
                    ->searchable(),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Active'),
                Tables\Columns\TextColumn::make('created_at')
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCelebrationVideos::route('/'),
            'create' => Pages\CreateCelebrationVideo::route('/create'),
            'edit' => Pages\EditCelebrationVideo::route('/{record}/edit'),
        ];
    }
}
