<?php

namespace App\Filament\Resources\SuratKeputusanResource\Pages;

use App\Filament\Exports\SuratKeputusanExporter;
use App\Filament\Resources\SuratKeputusanResource;
use Filament\Actions;
use Filament\Actions\ExportAction;
use Filament\Resources\Pages\ListRecords;

class ListSuratKeputusans extends ListRecords
{
    protected static string $resource = SuratKeputusanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            ExportAction::make()
                ->exporter(SuratKeputusanExporter::class),
        ];
    }
}
