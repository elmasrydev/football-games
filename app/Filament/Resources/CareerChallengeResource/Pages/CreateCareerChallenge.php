<?php

namespace App\Filament\Resources\CareerChallengeResource\Pages;

use App\Filament\Resources\CareerChallengeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCareerChallenge extends CreateRecord
{
    protected static string $resource = CareerChallengeResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Ensure game_id is set
        if (empty($data['game_id'])) {
            $game = \App\Models\Game::where('slug', 'career')->first();
            $data['game_id'] = $game?->id ?? 1;
        }
        
        return $data;
    }
}
