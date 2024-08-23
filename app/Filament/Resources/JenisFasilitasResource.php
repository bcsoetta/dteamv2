<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JenisFasilitasResource\Pages;
use App\Models\JenisFasilitas;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class JenisFasilitasResource extends Resource
{
    protected static ?string $model = JenisFasilitas::class;

    protected static ?string $navigationGroup = 'Settings';

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('nama_fasilitas')->required()->unique(ignoreRecord: true),
                Hidden::make('user_id')->default(auth()->id()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_fasilitas'),
                TextColumn::make('user.name'),
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
            'index' => Pages\ListJenisFasilitas::route('/'),
        ];
    }
}
