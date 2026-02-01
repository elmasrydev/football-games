<?php

namespace App\Filament\Resources\HintResource\Pages;

use App\Filament\Resources\HintResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHint extends EditRecord
{
    protected static string $resource = HintResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
