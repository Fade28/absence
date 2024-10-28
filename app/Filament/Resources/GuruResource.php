<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GuruResource\Pages;
use App\Filament\Resources\GuruResource\RelationManagers;
use App\Models\Guru;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\Post;
use Filament\Support\RawJs;

class GuruResource extends Resource
{

    protected static ?string $model = Guru::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama')->label("Nama Guru"),
                Forms\Components\TextInput::make('Jabatan')->label("Jabatan"),
                Forms\Components\TextInput::make('Gapok')
                    ->mask(RawJs::make('$money($input)'))
                    ->stripCharacters(',')
                    ->numeric()
                    ->prefix("Rp. ")
                    ->dehydrateStateUsing(fn($state) => preg_replace('/\D/', '', $state)),
                Forms\Components\TextInput::make('LaJab')->label("Lama Jabatan"),
                Forms\Components\FileUpload::make('avatar')->label("Foto Profil"),
            ])->columns(1);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('No')->rowIndex(),
                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama')
                    ->formatStateUsing(function ($record) {
                        $avatarPath = $record->avatar ? "/storage/{$record->avatar}" : 'https://cdn-icons-png.flaticon.com/512/6596/6596121.png';
                        return "<div class='flex items-center gap-3'>
                                <img src='$avatarPath' class='w-10 h-10 rounded-full' alt='Avatar'>
                                <div>
                                    <span>{$record->nama}</span><br>
                                    <small class='text-gray-500'>{$record->Jabatan}</small>
                                </div>
                            </div>";
                    })
                    ->html(),
                Tables\Columns\TextColumn::make('Gapok')
                    ->label('Gaji Pokok')
                    ->money('IDR')
                    ->alignCenter(),
                Tables\Columns\TextColumn::make('LaJab')
                    ->label('Lama Jabatan')
                    ->alignEnd()
                    ->formatStateUsing(fn($state) => "{$state} tahun"),
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
            'index' => Pages\ListGurus::route('/'),
            'create' => Pages\CreateGuru::route('/create'),
            'edit' => Pages\EditGuru::route('/{record}/edit'),
        ];
    }

    public function beforeSave($record)
    {
        $record->Gapok = str_replace(',', '', $record->amount); // Menghapus titik
        // $record->amount = str_replace('Rp', '', $record->amount); // Menghapus prefix Rp jika diperlukan
    }
}
