<?php

namespace App\Filament\Resources\BlackWhiteVideoResource\Pages;

use App\Filament\Resources\BlackWhiteVideoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBlackWhiteVideos extends ListRecords
{
    protected static string $resource = BlackWhiteVideoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
