<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TindakLanjutSkepResource\Pages;
use App\Models\JenisTindakLanjut;
use App\Models\SuratKeputusan;
use App\Models\TindakLanjutSkep;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TindakLanjutSkepResource extends Resource
{
    protected static ?string $model = TindakLanjutSkep::class;

    protected static ?string $navigationLabel = 'Tindak Lanjut';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationIcon = 'heroicon-o-document-plus';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('skep_id')->required()
                    ->options(SuratKeputusan::all()->pluck('nomor_skep', 'id'))
                    ->searchable(),
                Select::make('tindak_lanjut_id')->required()
                    ->options(JenisTindakLanjut::all()->pluck('nama_tindak_lanjut', 'id'))
                    ->searchable(),
                TextInput::make('nomor_surat_tindak_lanjut')->required()->unique(ignoreRecord: true),
                DatePicker::make('tanggal_surat_tindak_lanjut')->required(),
                DatePicker::make('tanggal_jatuh_tempo')->nullable(),
                TextInput::make('nilai_tindak_lanjut_rupiah')->nullable()
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric(),
                FileUpload::make('file_tindak_lanjut')->nullable()
                    ->acceptedFileTypes(['application/pdf'])
                    ->maxSize(2048),
                TextInput::make('keterangan')->nullable(),
                Hidden::make('user_id')->default(auth()->id()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('tindakLanjut.nama_tindak_lanjut')
                    ->badge()
                    ->color('tindakLanjut.warna_label'),
                TextColumn::make('nomor_surat_tindak_lanjut')->searchable(),
                TextColumn::make('tanggal_surat_tindak_lanjut')->sortable()->searchable(),
                TextColumn::make('tanggal_jatuh_tempo')->sortable()->searchable(),
                TextColumn::make('nilai_tindak_lanjut_rupiah'),
                TextColumn::make('skep.nomor_skep')->searchable(),
                TextColumn::make('skep.perusahaan.nama_perusahaan')->searchable(),
                TextColumn::make('keterangan'),
                TextColumn::make('user.name'),
            ])
            ->defaultSort('created_at', 'desc')
            ->defaultPaginationPageOption(5)
            ->filters([
                Filter::make('tanggal_tindak_lanjut')
                    ->form([
                        DatePicker::make('tgl_tindak_lanjut_from'),
                        DatePicker::make('tgl_tindak_lanjut_until'),
                        DatePicker::make('jatuh_tempo_from'),
                        DatePicker::make('jatuh_tempo_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['tgl_tindak_lanjut_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('tanggal_surat_tindak_lanjut', '>=', $date),
                            )
                            ->when(
                                $data['tgl_tindak_lanjut_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('tanggal_surat_tindak_lanjut', '<=', $date),
                            )
                            ->when(
                                $data['jatuh_tempo_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('tanggal_jatuh_tempo', '>=', $date),
                            )
                            ->when(
                                $data['jatuh_tempo_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('tanggal_jatuh_tempo', '<=', $date),
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
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTindakLanjutSkeps::route('/'),
            'create' => Pages\CreateTindakLanjutSkep::route('/create'),
            'edit' => Pages\EditTindakLanjutSkep::route('/{record}/edit'),
        ];
    }
}
