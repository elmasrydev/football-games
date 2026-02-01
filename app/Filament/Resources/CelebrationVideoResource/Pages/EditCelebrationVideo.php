<?php

namespace App\Filament\Resources\CelebrationVideoResource\Pages;

use App\Filament\Resources\CelebrationVideoResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCelebrationVideo extends EditRecord
{
    protected static string $resource = CelebrationVideoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
