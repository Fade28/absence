<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Absence extends Model
{
    use HasFactory;

    public function guruDiganti()
    {
        return $this->belongsTo(Guru::class, 'id_Diganti');
    }
    public function guruMengganti()
    {
        return $this->belongsTo(Guru::class, 'id_Mengganti');
    }
    public function Jenis()
    {
        return $this->belongsTo(SatuanGanti::class, 'Jenis_Potongan');
    }

}
