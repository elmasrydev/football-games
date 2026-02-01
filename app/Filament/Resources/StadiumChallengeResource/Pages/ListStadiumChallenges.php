<?php

namespace App\Filament\Resources\StadiumChallengeResource\Pages;

use App\Filament\Resources\StadiumChallengeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStadiumChallenges extends ListRecords
{
    protected static string $resource = StadiumChallengeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
