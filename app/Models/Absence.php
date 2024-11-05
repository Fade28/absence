<?php

namespace App\Models;

use App\Filament\Resources\AbsenceResource;
use DB;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Absence extends Model
{
    use HasFactory;



    // public static function create(array $attributes = [])
    // {
    //     // Logika untuk membagi total potongan dan membuat multiple entri
    //     // ... (salin kode dari event listener ke sini)
    //     // dd($attributes);
    //     // dd($potongan->id_Mengganti);
    //     // $guruIds = $attributes['id_Mengganti'];
    //     // $totalPotongan = $attributes['Total_Potongan'];

    //     // if (!empty($guruIds) || count($guruIds) != 0) {
    //     //     // dd($guruIds);
    //     //     $potonganPerGuru = $totalPotongan / count($guruIds);

    //     //     foreach ($guruIds as $guruId) {
    //     //         Absence::insert([
    //     //             'id_Diganti' => $attributes['id_Diganti'],
    //     //             'Tanggal' => $attributes['Tanggal'],
    //     //             'id_Mengganti' => $guruId,
    //     //             'Jenis_Potongan' => $attributes['Jenis_Potongan'],
    //     //             'Jumlah' => $attributes['Jumlah'],
    //     //             'Total_Potongan' => $potonganPerGuru,
    //     //             'created_at' => now(),
    //     //             'updated_at' => now(),
    //     //         ]);
    //     //     }
    //     // } else {
    //     //     // dd($potongan);
    //     //     Absence::insert([
    //     //         'id_Diganti' => $attributes['id_Diganti'],
    //     //         'Tanggal' => $attributes['Tanggal'],
    //     //         'id_Mengganti' => null,
    //     //         'Jenis_Potongan' => $attributes['Jenis_Potongan'],
    //     //         'Jumlah' => $attributes['Jumlah'],
    //     //         'Total_Potongan' => $attributes['Total_Potongan'],
    //     //         'created_at' => now(),
    //     //         'updated_at' => now(),
    //     //     ]);
    //     // }
    //     // Simpan data menggunakan metode create dari kelas induk
    //     return parent::getModel()::select();
    // }
    public function guruDiganti()
    {
        return $this->belongsTo(Guru::class, 'id_Diganti');
    }
    public function guruMengganti()
    {
        return $this->belongsTo(Guru::class, 'id_Mengganti');
    }
    public function getGuruMenggantiNamaAttribute()
    {
        return $this->guruMengganti?->nama ?: 'Tanpa Pengganti';
    }
    public function Jenis()
    {
        return $this->belongsTo(SatuanGanti::class, 'Jenis_Potongan', 'id');
    }

}
