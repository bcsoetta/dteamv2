<?php

namespace App\Filament\Exports;

use App\Models\SuratKeputusan;
use Filament\Actions\Exports\ExportColumn;
use Filament\Actions\Exports\Exporter;
use Filament\Actions\Exports\Models\Export;

class SuratKeputusanExporter extends Exporter
{
    protected static ?string $model = SuratKeputusan::class;

    public static function getColumns(): array
    {
        return [
            ExportColumn::make('id')
                ->label('ID'),
            ExportColumn::make('fasilitas.nama_fasilitas'),
            ExportColumn::make('tindakLanjutSkep.tindakLanjut.nama_tindak_lanjut'),
            ExportColumn::make('tindakLanjutSkep.tanggal_jatuh_tempo')->label('Jatuh tempo perpanjangan'),
            ExportColumn::make('nomor_skep'),
            ExportColumn::make('tanggal_skep'),
            ExportColumn::make('jatuh_tempo'),
            ExportColumn::make('perusahaan.npwp_perusahaan'),
            ExportColumn::make('perusahaan.nama_perusahaan'),
            ExportColumn::make('waktu_mulai'),
            ExportColumn::make('waktu_selesai'),
            ExportColumn::make('user.name'),
            ExportColumn::make('keterangan'),
            ExportColumn::make('created_at'),
            ExportColumn::make('updated_at'),
        ];
    }

    public static function getCompletedNotificationBody(Export $export): string
    {
        $body = 'Your surat keputusan export has completed and '.number_format($export->successful_rows).' '.str('row')->plural($export->successful_rows).' exported.';

        if ($failedRowsCount = $export->getFailedRowsCount()) {
            $body .= ' '.number_format($failedRowsCount).' '.str('row')->plural($failedRowsCount).' failed to export.';
        }

        return $body;
    }
}
