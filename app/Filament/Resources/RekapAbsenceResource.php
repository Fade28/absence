<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RekapAbsenceResource\Pages;
use App\Filament\Resources\RekapAbsenceResource\RelationManagers;
use App\Models\Absence;
use App\Models\Guru;
use App\Models\rekapAbsen;
use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\Summarizers\Sum;

class RekapAbsenceResource extends Resource
{
    protected static ?string $model = rekapAbsen::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('guruMengganti.nama')->label('Nama Guru'),
                TextColumn::make('total_potongan')->label('Total Potongan')
                    ->getStateUsing(function ($record) {
                        return $record->Jumlah_Potongan * $record->Jenis->Jumlah_Potongan;
                    })
                    ->money('IDR')
                    ->alignCenter(),
            ])
            ->defaultGroup('guruDiganti.nama')
            // ->groupsOnly()
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
            'index' => Pages\ListRekapAbsences::route('/'),
            'create' => Pages\CreateRekapAbsence::route('/create'),
            'edit' => Pages\EditRekapAbsence::route('/{record}/edit'),
        ];
    }
}
