<?php

namespace App\Filament\Resources\HintResource\Pages;

use App\Filament\Resources\HintResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListHints extends ListRecords
{
    protected static string $resource = HintResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
