<?php

namespace App\Filament\Resources\JenisTindakLanjutResource\Pages;

use App\Filament\Resources\JenisTindakLanjutResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListJenisTindakLanjuts extends ListRecords
{
    protected static string $resource = JenisTindakLanjutResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
