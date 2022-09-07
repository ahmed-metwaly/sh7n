<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OutShipmentPrice extends Model
{
    protected $table = 'out_shipment_prices';

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
        return $this->belongsTo(OutShipment::class, 'out_shipment_id', 'id');
    }
}
