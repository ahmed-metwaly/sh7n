<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'add_by', 'id');
    }
}
