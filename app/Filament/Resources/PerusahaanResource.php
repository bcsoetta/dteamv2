<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PerusahaanResource\Pages;
use App\Models\Perusahaan;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PerusahaanResource extends Resource
{
    protected static ?string $model = Perusahaan::class;

    protected static ?string $navigationLabel = 'Daftar Perusahaan';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('npwp_perusahaan')->required()->unique(ignoreRecord: true),
                TextInput::make('nama_perusahaan')->required()->unique(ignoreRecord: true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('npwp_perusahaan'),
                TextColumn::make('nama_perusahaan'),
                TextColumn::make('created_at'),
                TextColumn::make('updated_at'),
            ])
            ->defaultPaginationPageOption(5)
            ->filters([
                //
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPerusahaans::route('/'),
        ];
    }
}
