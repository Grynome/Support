<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravolt\Indonesia\Models\Province;
use Laravolt\Indonesia\Models\City;
use Laravolt\Indonesia\Models\District;
use Laravolt\Indonesia\Models\Village;

class Customer extends Model
{
    protected $table = 'hgt_end_user';

    public $primaryKey = 'id';

    protected $fillable = [
        'end_user_id', 'end_user_name', 'office_type_id', 'contact_person', 'phone', 'ext_phone', 'email', 'provinces', 'cities', 'address', 'deleted', 'created_at' 
    ];

    public $incrementing = false;
    public function get_provinces(){
        return $this->belongsTo(Province::class, 'provinces', 'id');
    }
    public function get_kab(){
        return $this->belongsTo(City::class, 'cities', 'id');
    }
    public function get_office(){
        return $this->belongsTo(OfficeType::class, 'office_type_id', 'office_type_id');
    }
}
