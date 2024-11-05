<?php

namespace App\Livewire;

use App\Models\Absence;
use Arr;
use DB;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Filters\QueryBuilder\Constraints\DateConstraint;
use Filament\Tables\Filters\QueryBuilder\Constraints\TextConstraint;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Support\Carbon;
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
                TextColumn::make('guruMengganti.nama')
                    ->label('Guru Mengganti'),
                TextColumn::make('Jumlah')->label('Jumlah mengGanti')->summarize(Sum::make()->label(''))->alignCenter(),
                TextColumn::make('Total_Potongan')->label('Total Tambahan')->money('IDR')->summarize(Sum::make()->label(''))->alignEnd(), // Menambahkan styling untuk total

            ])
            ->defaultGroup('guruMengganti.nama')
            ->groupsOnly()
            ->defaultSort('guruMengganti.nama', 'asc')
            ->filters([
                SelectFilter::make('Tanggal')
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
            ->filtersFormColumns(2)
            ->deferFilters();

    }
    public function render()
    {
        return view('livewire.list-report-mengganti');
    }
}
