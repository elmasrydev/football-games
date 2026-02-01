<?php

namespace App\Filament\Resources\SilhouetteChallengeResource\Pages;

use App\Filament\Resources\SilhouetteChallengeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSilhouetteChallenges extends ListRecords
{
    protected static string $resource = SilhouetteChallengeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
