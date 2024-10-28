<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SatuanGantiResource\Pages;
use App\Models\SatuanGanti;
use Filament\Forms\Components\Component;
use Filament\Forms\Form;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Support\RawJs;

class SatuanGantiResource extends Resource
{
    protected static ?string $model = SatuanGanti::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('Jenis_Ganti')
                    ->label('Jenis Ganti')
                    ->placeholder('Exmple : Jam / Izin'),
                Forms\Components\TextInput::make('Jumlah_Potongan')
                    ->label('Jumlah Potongan')
                    ->placeholder('Exmple : 15,000')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric()
                    ->prefix("Rp. ")
                    ->dehydrateStateUsing(fn($state) => preg_replace('/\D/', '', $state)),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('No.')->rowIndex(),
                Tables\Columns\TextColumn::make('Jenis_Ganti')->label('Jenis Ganti'),
                Tables\Columns\TextColumn::make('Jumlah_Potongan')->label('Jumlah Potongan'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListSatuanGantis::route('/'),
            'create' => Pages\CreateSatuanGanti::route('/create'),
            'edit' => Pages\EditSatuanGanti::route('/{record}/edit'),
        ];
    }
}
