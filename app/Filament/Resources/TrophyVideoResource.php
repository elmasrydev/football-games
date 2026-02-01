<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TrophyVideoResource\Pages;
use App\Models\Video;
use App\Models\Game;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TrophyVideoResource extends Resource
{
    protected static ?string $model = Video::class;

    protected static ?string $navigationIcon = 'heroicon-o-trophy';

    protected static ?string $navigationGroup = 'Games';

    protected static ?string $navigationLabel = 'Trophy Hunter';

    protected static ?string $modelLabel = 'Trophy Moment';

    protected static ?string $slug = 'trophy-videos';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->whereHas('game', fn ($q) => $q->where('slug', 'trophy-hunter'));
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('game_id')
                    ->default(fn () => Game::where('slug', 'trophy-hunter')->first()?->id),
                Forms\Components\TextInput::make('youtube_url')
                    ->label('YouTube URL')
                    ->placeholder('https://www.youtube.com/watch?v=...')
                    ->live(onBlur: true),
                Forms\Components\FileUpload::make('uploaded_video')
                    ->directory('videos/trophies')
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
                    ->default('Which trophy is being lifted here?')
                    ->placeholder('e.g. Which trophy is being lifted here?')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('answer')
                    ->required()
                    ->placeholder('e.g. Champions League 2005')
                    ->helperText('Format: Competition Year (e.g., "World Cup 2010", "Champions League 2015")'),
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
                    ->label('Trophy & Year')
                    ->searchable()
                    ->badge()
                    ->color('warning'),
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
                //
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
            'index' => Pages\ListTrophyVideos::route('/'),
            'create' => Pages\CreateTrophyVideo::route('/create'),
            'edit' => Pages\EditTrophyVideo::route('/{record}/edit'),
        ];
    }
}
