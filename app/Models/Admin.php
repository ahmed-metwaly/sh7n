<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\AdminResetPasswordNotification;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $guard = 'admin';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'mobile', 'status', 'image', 'password', 'level_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new AdminResetPasswordNotification($token));
    }

    public function activate()
    {
        if($this->id==1){
            return " <button style='margin-top: 20px' disabled type='button' class='btn btn-success btn-rounded waves-effect waves-light'>
                <span class='btn-label'><i class='fa fa-check'></i></span>
                مفعل</button>";
        }
        $var = route('active_admin',['id'=>$this->id]);
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
    public function scopeActive($query)
    {
        $query->where('status','active');
    }




    public function categories()
    {
        return $this->hasMany(Category::class, 'add_by', 'id');
    }
    public function countries()
    {
        return $this->hasMany(Country::class, 'add_by', 'id');
    }
    public function clients()
    {
        return $this->hasMany(Client::class, 'add_by', 'id');
    }
    public function pages()
    {
        return $this->hasMany(Page::class, 'add_by', 'id');
    }
    public function socials()
    {
        return $this->hasMany(Social::class, 'add_by', 'id');
    }
}
