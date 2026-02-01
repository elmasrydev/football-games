<?php

namespace App\Filament\Resources\StadiumChallengeResource\Pages;

use App\Filament\Resources\StadiumChallengeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStadiumChallenge extends EditRecord
{
    protected static string $resource = StadiumChallengeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
