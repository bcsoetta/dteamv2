<?php

namespace App\Filament\Resources\TindakLanjutSkepResource\Pages;

use App\Filament\Resources\TindakLanjutSkepResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTindakLanjutSkeps extends ListRecords
{
    protected static string $resource = TindakLanjutSkepResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
