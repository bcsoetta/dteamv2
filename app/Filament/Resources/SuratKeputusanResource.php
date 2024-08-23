<?php

namespace App\Filament\Resources;

use App\Filament\Exports\SuratKeputusanExporter;
use App\Filament\Resources\SuratKeputusanResource\Pages;
use App\Filament\Resources\SuratKeputusanResource\RelationManagers\TindakLanjutSkepRelationManager;
use App\Models\JenisFasilitas;
use App\Models\Perusahaan;
use App\Models\SuratKeputusan;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class SuratKeputusanResource extends Resource
{
    protected static ?string $model = SuratKeputusan::class;

    protected static ?string $navigationLabel = 'Surat Keputusan';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('fasilitas_id')->required()
                    ->options(JenisFasilitas::all()->pluck('nama_fasilitas', 'id'))
                    ->searchable(),
                TextInput::make('nomor_skep')->required()->unique(ignoreRecord: true),
                DatePicker::make('tanggal_skep')->required(),
                DatePicker::make('jatuh_tempo')->required(),
                Select::make('perusahaan_id')->required()
                    ->options(Perusahaan::all()->pluck('nama_perusahaan', 'id'))
                    ->searchable()
                    ->createOptionForm([
                        TextInput::make('npwp_perusahaan')
                            ->required(),
                        TextInput::make('nama_perusahaan')
                            ->required(),
                    ]),
                FileUpload::make('file_skep')->nullable()
                    ->acceptedFileTypes(['application/pdf'])
                    ->maxSize(2048),
                DateTimePicker::make('waktu_mulai')->required(),
                DateTimePicker::make('waktu_selesai')->required(),
                TextInput::make('keterangan')->nullable(),
                Hidden::make('user_id')->default(auth()->id()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->searchable()
            ->columns([
                TextColumn::make('nomor_skep'),
                TextColumn::make('tanggal_skep')->sortable(),
                TextColumn::make('jatuh_tempo')->sortable(),
                TextColumn::make('perusahaan.nama_perusahaan')->sortable(),
                TextColumn::make('fasilitas.nama_fasilitas')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Pembebasan' => 'success',
                        'Keringanan' => 'warning',
                        'Tanpa Fasilitas' => 'danger',
                    }),
                TextColumn::make('tindakLanjutSkep.tindakLanjut.nama_tindak_lanjut')
                    ->sortable()
                    ->badge()
                    ->color(fn (Model $record): string => $record->warna_label == null ? 'dark' : $record->warna_label),
                TextColumn::make('tindakLanjutSkep.tanggal_jatuh_tempo')->label('Jatuh tempo perpanjangan')->sortable(),
                TextColumn::make('waktu_mulai')->sortable(),
                TextColumn::make('waktu_selesai')->sortable(),
                TextColumn::make('keterangan')->sortable(),
                TextColumn::make('user.name')->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->defaultPaginationPageOption(5)
            ->filters([
                SelectFilter::make('tindak_lanjut')
                    ->relationship('tindakLanjutSkep.tindakLanjut', 'nama_tindak_lanjut')
                    ->searchable()
                    ->preload(),
                Filter::make('tanggal_skep')
                    ->form([
                        DatePicker::make('tgl_skep_from'),
                        DatePicker::make('tgl_skep_until'),
                        DatePicker::make('jatuh_tempo_from'),
                        DatePicker::make('jatuh_tempo_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['tgl_skep_from'] ?? null,
                                fn (Builder $query, $date): Builder => $query->whereDate('tanggal_skep', '>=', $date),
                            )
                            ->when(
                                $data['tgl_skep_until'] ?? null,
                                fn (Builder $query, $date): Builder => $query->whereDate('tanggal_skep', '<=', $date),
                            )
                            ->when(
                                $data['jatuh_tempo_from'] ?? null,
                                fn (Builder $query, $date): Builder => $query
                                    ->where(function ($query) use ($date) {
                                        $query->whereDate('jatuh_tempo', '>=', $date)
                                            ->orWhereHas('tindakLanjutSkep', function ($query) use ($date) {
                                                $query->whereDate('tanggal_jatuh_tempo', '>=', $date);
                                            });
                                    })
                            )
                            ->when(
                                $data['jatuh_tempo_until'] ?? null,
                                fn (Builder $query, $date): Builder => $query
                                    ->where(function ($query) use ($date) {
                                        $query->whereDate('jatuh_tempo', '<=', $date)
                                            ->orWhereHas('tindakLanjutSkep', function ($query) use ($date) {
                                                $query->whereDate('tanggal_jatuh_tempo', '<=', $date);
                                            });
                                    })
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
                Tables\Actions\ExportBulkAction::make()
                    ->exporter(SuratKeputusanExporter::class),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            TindakLanjutSkepRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSuratKeputusans::route('/'),
            'create' => Pages\CreateSuratKeputusan::route('/create'),
            'edit' => Pages\EditSuratKeputusan::route('/{record}/edit'),
        ];
    }
}
