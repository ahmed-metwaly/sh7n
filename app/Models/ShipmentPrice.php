<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShipmentPrice extends Model
{
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'add_by', 'id');
    }
    public function buy_type()
    {
        return $this->belongsTo(BuyType::class, 'buy_type_id', 'id');
    }
    public function shipment()
    {
        return $this->belongsTo(Shipment::class, 'shipment_id', 'id');
    }
}
