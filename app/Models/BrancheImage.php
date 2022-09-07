<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BrancheImage extends Model
{
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'add_by', 'id');
    }
    public function setNameAttribute($image)
    {
        $file = $image;
        $destinationPath = 'images/branche/';
        $filename = $file->getClientOriginalName();
        $file->move($destinationPath, $filename);
        $this->attributes['name'] = $filename;
    }
}
