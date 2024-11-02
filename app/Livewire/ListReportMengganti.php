<?php

namespace App\Livewire;

use App\Models\Absence;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Table;
use Livewire\Component;
use Filament\Tables\Columns\Summarizers\Sum;

class ListReportMengganti extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;

    public static function table(Table $table): Table
    {
        return $table
            ->heading('Table Tambahan mengGanti')
            ->query(Absence::with('Jenis')) // Memuat relasi yang diperlukan
            ->columns([
                TextColumn::make('guruMengganti.nama')->label('Guru Mengganti'),
                TextColumn::make('Jumlah')->label('Jumlah mengGanti')->summarize(Sum::make()->label(''))->alignCenter(),
                TextColumn::make('Total_Potongan')->label('Total Tambahan')->money('IDR')->summarize(Sum::make()->label(''))->alignEnd(), // Menambahkan styling untuk total

            ])
            ->defaultGroup('guruMengganti.nama')
            ->groupsOnly()
            ->filters([
                //
            ]);

    }
    public function render()
    {
        return view('livewire.list-report-mengganti');
    }
}
