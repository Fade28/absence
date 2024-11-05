<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AbsenceResource\Pages;
use App\Models\Absence;
use App\Models\Guru;
use App\Models\SatuanGanti;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Pages\Actions\CreateAction;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AbsenceResource extends Resource
{
    protected static ?string $model = Absence::class;
    // Menonaktifkan edit

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
                    ->multiple()
                    ->searchable(),
                Forms\Components\TextInput::make('Jumlah')
                    ->label('Jumlah yang diganti')
                    ->numeric()
                    ->minValue(1)
                    ->reactive()
                    ->afterStateUpdated(function ($state, $set, $get) {
                        // Ambil harga dari jenis yang dipilih
                        $jenisid = $get('Jenis_Potongan');
                        $harga = SatuanGanti::find($jenisid)?->Jumlah_Potongan ?? 0;
                        $jumlah = $get('Jumlah') ?? 1;
                        // Set nilai total dari jumlah * harga
                        $set('Total_Potongan', $jumlah * $harga);

                    }),
                Forms\Components\Select::make('Jenis_Potongan')
                    ->label('Satuan Waktu')
                    ->options(SatuanGanti::all()->pluck('Jenis_Ganti', 'id'))
                    ->reactive()
                    ->afterStateUpdated(function ($state, $set, $get) {
                        // Ambil harga dari jenis yang dipilih
                        $harga = SatuanGanti::find($state)?->Jumlah_Potongan ?? 0;
                        $jumlah = $get('Jumlah') ?? 1;
                        // Set nilai total dari jumlah * harga
                        $set('Total_Potongan', $jumlah * $harga);

                    }),
                Forms\Components\DatePicker::make('Tanggal')
                    ->native(false)
                    ->maxDate(now()),
                Forms\Components\TextInput::make('Total_Potongan')

            ])
            ->model(Absence::class);
    }
    // public function create(): void
    // {
    //     $post = Absence::create($this->form);

    //     // Save the relationships from the form to the post after it is created.
    //     $this->form->model($post)->saveRelationships();
    // }
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('No.')->rowIndex(),
                Tables\Columns\TextColumn::make('guruDiganti.nama')->label('Guru Diganti'),
                Tables\Columns\TextColumn::make('guruMengganti.nama')->label('Guru Mengganti'),
                Tables\Columns\TextColumn::make('Tanggal')->sortable(),
                Tables\Columns\TextColumn::make('Jenis.Jenis_Ganti')->label('Guru Diganti'),
                Tables\Columns\TextColumn::make('Total_Potongan')->label('Total Potongan')
                    ->money('IDR')
                    ->alignCenter(),
            ])
            ->filters([
                //
            ])
            ->actions([
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

    public static function getActions(): array
    {
        return [
            CreateAction::make()
                ->using(function (array $data) {
                    dd($data);
                    // return $record;
                }),
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAbsences::route('/'),
            'create' => Pages\CreateAbsence::route('/create'),
            // 'edit' => Pages\EditAbsence::route('/{record}/edit'),
        ];
    }
}
