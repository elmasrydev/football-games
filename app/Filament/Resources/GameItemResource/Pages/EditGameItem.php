<?php

namespace App\Filament\Resources\GameItemResource\Pages;

use App\Filament\Resources\GameItemResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGameItem extends EditRecord
{
    protected static string $resource = GameItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
