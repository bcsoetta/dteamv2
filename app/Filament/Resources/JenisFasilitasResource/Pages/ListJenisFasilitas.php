<?php

namespace App\Filament\Resources\JenisFasilitasResource\Pages;

use App\Filament\Resources\JenisFasilitasResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListJenisFasilitas extends ListRecords
{
    protected static string $resource = JenisFasilitasResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
