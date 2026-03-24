<?php

namespace App\Filament\Resources\GroupChallengeResource\Pages;

use App\Filament\Resources\GroupChallengeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGroupChallenge extends EditRecord
{
    protected static string $resource = GroupChallengeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
