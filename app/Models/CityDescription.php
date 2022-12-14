<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CityDescription extends Model
{
    public function city()
    {
        return $this->belongsTo(City::class);
    }
    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
