<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravolt\Indonesia\Models\District as LaravoltDistrict;
use App\Models\KAB;

class KEC extends LaravoltDistrict
{
    public function kab()
    {
        return $this->belongsTo(KAB::class, 'city_code', 'code');
    }
}
