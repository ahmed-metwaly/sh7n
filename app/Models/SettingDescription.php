<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingDescription extends Model
{
    public function language()
    {
        return $this->belongsTo(Language::class);
    }
    public function setting()
    {
        return $this->belongsTo(Setting::class);
    }

}
