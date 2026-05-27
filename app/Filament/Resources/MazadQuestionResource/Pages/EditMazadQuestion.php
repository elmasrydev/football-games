<?php

namespace App\Filament\Resources\MazadQuestionResource\Pages;

use App\Filament\Resources\MazadQuestionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMazadQuestion extends EditRecord
{
    protected static string $resource = MazadQuestionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
