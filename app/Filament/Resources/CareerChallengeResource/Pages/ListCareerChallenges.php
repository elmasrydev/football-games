<?php

namespace App\Filament\Resources\CareerChallengeResource\Pages;

use App\Filament\Resources\CareerChallengeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCareerChallenges extends ListRecords
{
    protected static string $resource = CareerChallengeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
