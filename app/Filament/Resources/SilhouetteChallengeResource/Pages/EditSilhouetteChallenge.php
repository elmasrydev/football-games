<?php

namespace App\Filament\Resources\SilhouetteChallengeResource\Pages;

use App\Filament\Resources\SilhouetteChallengeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSilhouetteChallenge extends EditRecord
{
    protected static string $resource = SilhouetteChallengeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
