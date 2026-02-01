<?php

namespace App\Filament\Resources\TrophyVideoResource\Pages;

use App\Filament\Resources\TrophyVideoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTrophyVideo extends EditRecord
{
    protected static string $resource = TrophyVideoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
