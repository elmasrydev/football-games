<?php

namespace App\Filament\Resources\GameItemResource\Pages;

use App\Filament\Resources\GameItemResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGameItems extends ListRecords
{
    protected static string $resource = GameItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
