<?php

namespace App\Filament\Resources\BlackWhiteVideoResource\Pages;

use App\Filament\Resources\BlackWhiteVideoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBlackWhiteVideo extends EditRecord
{
    protected static string $resource = BlackWhiteVideoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
