<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravolt\Indonesia\Models\City as LaravoltCity;
use Laravolt\Indonesia\Models\Province;

class KAB extends LaravoltCity
{
    public function pv()
    {
        return $this->belongsTo(Province::class, 'province_code', 'code');
    }
}
