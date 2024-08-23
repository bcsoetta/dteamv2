<?php

namespace App\Filament\Resources\JenisTindakLanjutResource\Pages;

use App\Filament\Resources\JenisTindakLanjutResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJenisTindakLanjut extends EditRecord
{
    protected static string $resource = JenisTindakLanjutResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
