<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Client extends Authenticatable
{
    use Notifiable;

    protected $guard = 'client';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'mobile', 'password', 'status', 'image'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function scopeActive($query)
    {
        $query->where('status','active');
    }
    public function setImageAttribute($image)
    {
        $file = request()->file('image');
        $destinationPath = 'images/user/';
        $filename = $file->getClientOriginalName();
        $file->move($destinationPath, $filename);
        $this->attributes['image'] = $filename;
    }
    public function setPasswordAttribute($password)
    {
        if (isset($password)) {
            $this->attributes['password'] = bcrypt($password);
        }
    }
    public function activate()
    {
        $var = route('active_client',['id'=>$this->id]);
        $token = csrf_token();
        if($this->status=='active') {
            return "<form style='margin-top: 20px' method='POST' action='$var' class='form-horizontal'>
                <input type='hidden' name='_token' value='$token'>
                <button type='submit' class='btn btn-danger btn-rounded waves-effect waves-light'>
                <span class='btn-label'><i class='fa fa-times'></i></span>
                الغاء التفعيل</button>
                
            </form>";
        }
        return "<form style='margin-top: 20px' method='POST' action='$var' class='form'>
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
