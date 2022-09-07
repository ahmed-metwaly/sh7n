<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShipmentPackage extends Model
{
    public function scopeActive($query)
    {
        $query->where('status','active');
    }
    public function activate()
    {
        $var = route('active_shipment_package',['id'=>$this->id]);
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
    protected $fillable = [
        'add_by', 'status','shipment_id','package_type_id'
    ];


    public function admin()
    {
        return $this->belongsTo(Admin::class, 'add_by', 'id');
    }
    public function shipment()
    {
        return $this->belongsTo(Shipment::class, 'shipment_id', 'id');
    }
    public function package_type()
    {
        return $this->belongsTo(PackageType::class, 'package_type_id', 'id');
    }
}
