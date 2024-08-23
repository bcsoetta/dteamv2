<?php

namespace App\Filament\Resources\TindakLanjutSkepResource\Pages;

use App\Filament\Resources\TindakLanjutSkepResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditTindakLanjutSkep extends EditRecord
{
    protected static string $resource = TindakLanjutSkepResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
