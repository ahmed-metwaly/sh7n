<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Social extends Model
{
    public function scopeActive($query)
    {
        $query->where('status','active');
    }
    public function activate()
    {
        $var = route('active_social',['id'=>$this->id]);
        $token = csrf_token();
        if($this->status=='active') {
            return "<form method='POST' action='$var' class='form-horizontal'>
                <input type='hidden' name='_token' value='$token'>
                <button type='submit' class='btn btn-danger btn-rounded btn-custom waves-effect waves-light'>
                الغاء التفعيل</button>
            </form>";
        }
        return "<form method='POST' action='$var' class='form-horizontal'>
                <input type='hidden' name='_token' value='$token'>
                <button type='submit' class='btn btn-default btn-rounded btn-custom waves-effect waves-light'>
                تفعيل</button>
            </form>";
    }
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'add_by', 'id');
    }
}
