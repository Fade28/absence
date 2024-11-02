<?php

namespace App\Livewire;
use App\Models\Absence;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
class ListReportAbsence extends Component implements HasForms, HasTable
{
    use InteractsWithTable;
    use InteractsWithForms;


    public static function table(Table $table): Table
    {
        // $absences = Absence::with('jenis')
        //     ->select('id', 'id_Diganti', 'Jenis_Potongan', 'Jumlah')
        //     ->get();

        // // Siapkan array untuk menyimpan data debugging
        // $debugData = [];

        // // Tampilkan data Absence beserta atribut tertentu dari relasi Jenis
        // foreach ($absences as $absence) {
        //     $debugData[] = [
        //         'ID' => $absence->id,
        //         'ID Diganti' => $absence->id_Diganti,
        //         'Jumlah Potongan' => $absence->Jumlah,
        //         'Nama Jenis' => $absence->jenis ? $absence->jenis->Jenis_Ganti : 'Jenis tidak ditemukan'
        //     ];
        // }

        // // Gunakan dd() untuk menampilkan data debugging
        // dd($debugData);
        return $table
            ->heading('Table Potongan diGanti')
            // ->query(Absence::query())
            // ->query(function (Builder $query) {
            //     // Melakukan query dengan pengelompokan dan perhitungan total potongan
            //     $query->with('satuangantis') // Memuat relasi `Jenis`
            //         ->selectRaw('id_Diganti, SUM(jumlah_potongan * satuangantis.jumlah_potongan) as total_per_group')
            //         ->groupBy('id_Diganti');
            // })
            // ->query(function (Builder $query) {
            //     $query->selectRaw('id_diganti, guruMengganti_id, SUM(Jumlah_Potongan * Jenis.Jumlah_Potongan) as total_potongan')
            //         ->with('Jenis')
            //         ->groupBy('id_diganti', 'guruMengganti_id'); // Pastikan untuk mengelompokkan berdasarkan kolom yang relevan
            // })
            ->query(Absence::with('Jenis')) // Memuat relasi yang diperlukan
            ->columns([
                TextColumn::make('guruDiganti.nama')->label('Guru Diganti'),
                TextColumn::make('Jumlah')->label('Jumlah diGanti')->summarize(Sum::make()->label(''))->alignCenter(),
                // TextColumn::make('Jenis.Jumlah_Potongan')->label('Jumlah Potongan'),
                // TextColumn::make('Potongan')
                //     ->getStateUsing(function ($record) {
                //         return $record->Jumlah;
                //     })
                //     ->money('IDR')
                //     ->alignCenter(),
                TextColumn::make('Total_Potongan')->label('Total Potongan')->money('IDR')->summarize(Sum::make()->label(''))->alignEnd(), // Menambahkan styling untuk total

            ])
            ->defaultGroup('guruDiganti.nama')
            ->groupsOnly()

            ->filters([
                //
            ]);

    }
    public function render()
    {
        return view('livewire.list-report-absence');
    }
}
