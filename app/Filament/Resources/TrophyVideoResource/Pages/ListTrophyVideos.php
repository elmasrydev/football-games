<?php

namespace App\Filament\Resources\TrophyVideoResource\Pages;

use App\Filament\Resources\TrophyVideoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTrophyVideos extends ListRecords
{
    protected static string $resource = TrophyVideoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
