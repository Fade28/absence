<?php

namespace App\Livewire;
use App\Models\Absence;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\Summarizers\Sum;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
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
            ->defaultSort('guruDiganti.nama', 'asc')
            ->filters([
                SelectFilter::make('bulan')
                    ->label('Bulan')
                    ->multiple()
                    ->options([
                        '1' => 'Januari',
                        '2' => 'Februari',
                        '3' => 'Maret',
                        '4' => 'April',
                        '5' => 'Mei',
                        '6' => 'Juni',
                        '7' => 'Juli',
                        '8' => 'Agustus',
                        '9' => 'September',
                        '10' => 'Oktober',
                        '11' => 'November',
                        '12' => 'Desember',
                    ])
                    //         ->indicateUsing(function (array $data): array {
                    //             $indicators = [];
                    //             if ($data['Tanggal'] ?? null) {
                    //                 $indicators['Tanggal'] = 'Published from ' . Carbon::parse($data['Tanggal'])->toFormattedDateString();
                    //             }
                    //             if ($data['published_until'] ?? null) {
                    //                 $indicators['Tanggal'] = 'Published until ' . Carbon::parse($data['Tanggal'])->toFormattedDateString();
                    //             }

                    //             return $indicators;
                    //         })
                    ->query(function ($query, $state) {

                        $data = $state['values'];
                        logger()->info("Filter bulan selected: ", ['state' => $data]);

                        if (empty($state['values'])) {
                            logger()->info('No month selected, displaying all data.');
                            return $query;
                        }

                        // Memastikan state tidak kosong
                        if (is_array($state)) {
                            $flatState = array_filter($state['values']); // Hapus nilai null atau kosong
                            logger()->info("Filtered months: ", $flatState);

                            // Gunakan whereIn dengan array datanya
                            return $query->whereIn(DB::raw('MONTH(Tanggal)'), $flatState);
                        }

                        // return $query->whereMonth('Tanggal', $state);
                    }),
                SelectFilter::make('jenis')
                    ->label('Jenis Potongan')
                    ->options(
                        [
                            '1' => 'Tahfidz',
                            '2' => 'Bidang Studi'
                        ]
                    )
                    ->modifyQueryUsing(function ($query, $state) {

                        $data = $state['value'];

                        // if ($data == null) {
                        //     return $query;
                        // }

                        // Memastikan state tidak kosong
                        if ($data == '1') {
                            // dd($query->get());
                            // dd($query->Where('Jenis_Potongan', '4')->orWhere('Jenis_Potongan', '3'));
                            // $data = $query->Where('Jenis_Potongan', '4');

                            // dd($data);
                            return $query->whereIn('Jenis_Potongan', ['3', '4']);
                        } else if ($data == '2') {
                            return $query->whereIn('Jenis_Potongan', ['1', '2']);
                        }


                    }),
                // ])
                // QueryBuilder::make()
                //     ->constraints([
                //         // TextConstraint::make('guruMengganti.nama'),

                //         DateConstraint::make('Tanggal'),
                //     ])
                //     ->constraintPickerColumns(1),
                // Filter::make('Tanggal')
                //     ->form(
                //         [
                //             DatePicker::make('Tanggal')->extraInputAttributes(['type' => 'month'])
                //         ]
                //     )
            ], layout: FiltersLayout::AboveContentCollapsible)
            ->filtersFormColumns(1)
            ->deferFilters();
    }
    public function render()
    {
        return view('livewire.list-report-absence');
    }
}
