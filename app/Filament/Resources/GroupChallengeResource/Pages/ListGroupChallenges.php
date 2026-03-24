<?php

namespace App\Filament\Resources\GroupChallengeResource\Pages;

use App\Filament\Resources\GroupChallengeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGroupChallenges extends ListRecords
{
    protected static string $resource = GroupChallengeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
