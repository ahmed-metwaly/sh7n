<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Shipment extends Model
{
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'add_by', 'id');
    }
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }
    public function office()
    {
        return $this->belongsTo(Office::class, 'office_id', 'id');
    }
    public function shipment_packages()
    {
        return $this->hasMany(ShipmentPackage::class, 'shipment_id', 'id');
    }
    public function shipment_type()
    {
        return $this->belongsTo(ShipmentType::class, 'shipment_type_id', 'id');
    }

}
