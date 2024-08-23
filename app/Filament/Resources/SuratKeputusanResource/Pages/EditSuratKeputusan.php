<?php

namespace App\Filament\Resources\SuratKeputusanResource\Pages;

use App\Filament\Resources\SuratKeputusanResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSuratKeputusan extends EditRecord
{
    protected static string $resource = SuratKeputusanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
