<?php

namespace App\Filament\Resources\CelebrationVideoResource\Pages;

use App\Filament\Resources\CelebrationVideoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCelebrationVideos extends ListRecords
{
    protected static string $resource = CelebrationVideoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
