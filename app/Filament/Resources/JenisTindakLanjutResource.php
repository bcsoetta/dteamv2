<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JenisTindakLanjutResource\Pages;
use App\Models\JenisTindakLanjut;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class JenisTindakLanjutResource extends Resource
{
    protected static ?string $model = JenisTindakLanjut::class;

    protected static ?string $navigationGroup = 'Settings';

    protected static ?string $navigationLabel = 'Jenis Tindak Lanjut';

    protected static ?string $navigationIcon = 'heroicon-o-wrench-screwdriver';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama_tindak_lanjut')->required()->unique(ignoreRecord: true),
                Select::make('warna_label')->options(
                    [
                        'danger' => 'Merah',
                        'warning' => 'Kuning',
                        'success' => 'Hijau',
                        'primary' => 'Biru',
                        'dark' => 'Hitam',
                        'gray' => 'Abu-Abu',
                        'light' => 'White',
                    ]
                ),
                TextInput::make('keterangan')->required(),
                Hidden::make('user_id')->default(auth()->id()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_tindak_lanjut'),
                TextColumn::make('warna_label')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'danger' => 'danger',
                        'warning' => 'warning',
                        'success' => 'success',
                        'primary' => 'primary',
                        'dark' => 'dark',
                        'gray' => 'gray',
                        'light' => 'light',
                    }),
                TextColumn::make('keterangan'),
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
            'index' => Pages\ListJenisTindakLanjuts::route('/'),
        ];
    }
}
