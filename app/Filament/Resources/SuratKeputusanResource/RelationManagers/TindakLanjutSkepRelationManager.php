<?php

namespace App\Filament\Resources\SuratKeputusanResource\RelationManagers;

use App\Models\JenisTindakLanjut;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TindakLanjutSkepRelationManager extends RelationManager
{
    protected static string $relationship = 'tindakLanjutSkep';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('tindak_lanjut_id')->required()
                    ->options(JenisTindakLanjut::all()->pluck('nama_tindak_lanjut', 'id'))
                    ->searchable(),
                Forms\Components\TextInput::make('nomor_surat_tindak_lanjut')->required()->unique(ignoreRecord: true),
                Forms\Components\DatePicker::make('tanggal_surat_tindak_lanjut')->required(),
                Forms\Components\DatePicker::make('tanggal_jatuh_tempo')->nullable(),
                Forms\Components\TextInput::make('nilai_tindak_lanjut_rupiah')->nullable()
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric(),
                Forms\Components\FileUpload::make('file_tindak_lanjut')->nullable()
                    ->acceptedFileTypes(['application/pdf'])
                    ->maxSize(2048),
                Forms\Components\TextInput::make('keterangan')->nullable(),
                Forms\Components\Hidden::make('user_id')->default(auth()->id()),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nomor_surat_tindak_lanjut')
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
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
