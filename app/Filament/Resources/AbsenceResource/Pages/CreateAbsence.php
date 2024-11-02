<?php

namespace App\Filament\Resources\AbsenceResource\Pages;

use App\Filament\Resources\AbsenceResource;
use App\Models\Absence;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateAbsence extends CreateRecord
{
    protected static string $resource = AbsenceResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        // dd($data);
        // print ("teshandle");
        $models = [];
        $guruIds = $data['id_Mengganti'];
        $totalPotongan = $data['Total_Potongan'];
        if (!empty($guruIds) || count($guruIds) != 0) {
            // dd($guruIds);
            $potonganPerGuru = $totalPotongan / count($guruIds);

            foreach ($guruIds as $guruId) {
                $record['id_Diganti'] = $data['id_Diganti'];
                $record['Tanggal'] = $data['Tanggal'];
                $record['id_Mengganti'] = $guruId;
                $record['Jenis_potongan'] = $data['Jenis_Potongan'];
                $record['Jumlah'] = $data['Jumlah'];
                $record['Total_Potongan'] = $potonganPerGuru;
                $record['created_at'] = now();
                $record['updated_at'] = now();
                $model = static::getModel()::create($record);
                $models[] = $model;
                // Absence::insert([
                //     'id_Diganti' => $data['id_Diganti'],
                //     'Tanggal' => $data['Tanggal'],
                //     'id_Mengganti' => $guruId,
                //     'Jenis_Potongan' => $data['Jenis_Potongan'],
                //     'Jumlah' => $data['Jumlah'],
                //     'Total_Potongan' => $potonganPerGuru,
                //     'created_at' => now(),
                //     'updated_at' => now(),
                // ]);
            }
        } else {
            // dd($potongan);
            // Absence::insert([
            //     'id_Diganti' => $data['id_Diganti'],
            //     'Tanggal' => $data['Tanggal'],
            //     'id_Mengganti' => null,
            //     'Jenis_Potongan' => $data['Jenis_Potongan'],
            //     'Jumlah' => $data['Jumlah'],
            //     'Total_Potongan' => $data['Total_Potongan'],
            //     'created_at' => now(),
            //     'updated_at' => now(),
            // ]);
            $record['id_Diganti'] = $data['id_Diganti'];
            $record['Tanggal'] = $data['Tanggal'];
            $record['id_Mengganti'] = null;
            $record['Jenis_potongan'] = $data['Jenis_Potongan'];
            $record['Jumlah'] = $data['Jumlah'];
            $record['Total_Potongan'] = $data['Total_Potongan'];
            $record['created_at'] = now();
            $record['updated_at'] = now();
            $model = static::getModel()::create($record);
            $models[] = $model;
        }
        // logger("Insert Selesai");
        // $result = static::getModel()::create($data);
        // logger("Sudah dari create");

        return $models[0];
    }
    protected function afterCreate(): void
    {
        logger($this->record);
    }
}
