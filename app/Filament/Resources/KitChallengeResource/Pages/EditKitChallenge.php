<?php

namespace App\Filament\Resources\KitChallengeResource\Pages;

use App\Filament\Resources\KitChallengeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditKitChallenge extends EditRecord
{
    protected static string $resource = KitChallengeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
