<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jop extends Model
{
    protected $fillable = [
        'add_by', 'image', 'status'
    ];
    // public function setImageAttribute($image)
    // {
    //     $file = request()->file('image');
    //     $destinationPath = 'images/jop/';
    //     $filename = $file->getClientOriginalName();
    //     $file->move($destinationPath, $filename);
    //     $this->attributes['image'] = $filename;
    // }
    public function activate()
    {
        $var = route('active_jop',['id'=>$this->id]);
        $token = csrf_token();
        if($this->status=='active') {
            return "<form style='margin-top: 10px' method='POST' action='$var' class='form-horizontal'>
                <input type='hidden' name='_token' value='$token'>
                <button type='submit' class='btn btn-danger btn-rounded waves-effect waves-light'>
                <span class='btn-label'><i class='fa fa-times'></i></span>
                الغاء التفعيل</button>
                
            </form>";
        }
        return "<form style='margin-top: 10px' method='POST' action='$var' class='form'>
                <input type='hidden' name='_token' value='$token'>
                <button type='submit' class='btn btn-success btn-rounded waves-effect waves-light'>
                <span class='btn-label'><i class='fa fa-check'></i></span>
                تفعيل</button>
                
            </form>";
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'add_by', 'id');
    }
}
