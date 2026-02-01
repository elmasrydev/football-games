<?php

namespace App\Filament\Resources\CareerChallengeResource\Pages;

use App\Filament\Resources\CareerChallengeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCareerChallenge extends EditRecord
{
    protected static string $resource = CareerChallengeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
