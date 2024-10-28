<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AbsenceResource\Pages;
use App\Filament\Resources\AbsenceResource\RelationManagers;
use App\Models\Absence;
use App\Models\Guru;
use App\Models\SatuanGanti;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AbsenceResource extends Resource
{
    protected static ?string $model = Absence::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('id_Diganti')
                    ->label('Guru Diganti')
                    ->options(Guru::all()->pluck('nama', 'id'))
                    ->searchable(),
                Forms\Components\Select::make('id_Mengganti')
                    ->label('Guru Mengganti')
                    ->options(Guru::all()->pluck('nama', 'id'))
                    ->default('Tanpa Pengganti')
                    ->searchable(),
                Forms\Components\TextInput::make('Jumlah_Potongan')
                    ->label('Jumlah yang diganti')
                    ->numeric()
                    ->minValue(1),
                Forms\Components\Select::make('Jenis_Potongan')
                    ->label('Satuan Waktu')
                    ->options(SatuanGanti::all()->pluck('Jenis_Ganti', 'id'))
                    ->searchable(),
                Forms\Components\DatePicker::make('Tanggal')
                    ->native(false)
                    ->maxDate(now()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('No.')->rowIndex(),
                Tables\Columns\TextColumn::make('guruDiganti.nama')->label('Guru Diganti'),
                Tables\Columns\TextColumn::make('guruMengganti.nama')->label('Guru Diganti'),
                Tables\Columns\TextColumn::make('Tanggal'),
                Tables\Columns\TextColumn::make('Jenis.Jenis_Ganti')->label('Guru Diganti'),
                Tables\Columns\TextColumn::make('total_potongan')->label('Total Potongan')
                    ->getStateUsing(function ($record) {
                        return $record->Jumlah_Potongan * $record->Jenis->Jumlah_Potongan;
                    })
                    ->money('IDR')
                    ->alignCenter(),
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
            'index' => Pages\ListAbsences::route('/'),
            'create' => Pages\CreateAbsence::route('/create'),
            'edit' => Pages\EditAbsence::route('/{record}/edit'),
        ];
    }
}
