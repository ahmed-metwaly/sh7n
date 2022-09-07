<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManagementLevel extends Model
{
    protected $table = 'groups';

    public function byUser() {
        return $this->belongsTo('App\User', 'created_by', 'id');
    }
}
