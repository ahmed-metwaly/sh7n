<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    public function scopeActive($query)
    {
        $query->where('status','active');
    }
    public function type()
    {
        if($this->type == 'dept') {
            return "تسديد مديونية";
        }elseif($this->type == 'buy') {
            return "صرف";
        }else{
            return "قبض";
        }
    }
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'add_by', 'id');
    }
}
