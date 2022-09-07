<?php

namespace App\Http\Controllers\Admin;


use App\Models\Bill;
use App\Models\BuyType;
use App\Models\PackageType;
use App\Models\Purchase;
use App\Models\OutShipment;
use App\Models\OutShipmentPackage;
use App\Models\OutShipmentPrice;
use App\Models\Office;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

//use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;
use Analytics;
use Auth;

class OutShipmentController extends MasterController
{
    public function __construct(OutShipment $model)
    {

        $this->model = $model;
        $this->route = 'out-shipment';
        $this->module_name         = 'قائمة الطرود';
        $this->single_module_name  = 'طرد';
        $this->index_fields        = ['رقم الطرد' => 'id','اسم المرسل' => 'sender_name','اسم المستقبل' => 'receiver_name','هاتف المستقبل' => 'receiver_phone','هوية المستقبل' => 'receiver_identity'];
        $this->create_fields        = ['اسم المرسل' => 'sender_name','رقم هوية المرسل' => 'sender_identity','هاتف المرسل' => 'sender_phone','اسم المستقبل' => 'receiver_name','رقم هوية المستقبل' => 'receiver_identity','هاتف المستقبل' => 'receiver_phone','اسم السائق' => 'driver_name','رقم هوية السائق' => 'driver_identity','هاتف السائق' => 'driver_phone','رقم السيارة' => 'car_number'];
        $this->update_fields        = ['اسم المرسل' => 'sender_name','رقم هوية المرسل' => 'sender_identity','هاتف المرسل' => 'sender_phone','اسم المستقبل' => 'receiver_name','رقم هوية المستقبل' => 'receiver_identity','هاتف المستقبل' => 'receiver_phone','اسم السائق' => 'driver_name','رقم هوية السائق' => 'driver_identity','هاتف السائق' => 'driver_phone','رقم السيارة' => 'car_number'];
        parent::__construct();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function validation_func()
    {
        $therulesarray = [];
        $therulesarray['image'] = 'mimes:png,jpg,jpeg';
        return $therulesarray;
    }


    public function store(Request $request) {


        $this->validate($request, $this->validation_func());

        $package = PackageType::select('id')->get();

        for($i = 0; $i < count($request->sender_identity); $i++) {


            $shipment = new OutShipment();

            $shipment->add_by = $request->add_by;
            $shipment->city_id = $request->city_id[$i];
            $shipment->office_id = $request->office_id;
            $shipment->shipment_type_id = $request->shipment_type_id[$i];

            $shipment->sender_name = $request->sender_name[$i];
            $shipment->sender_identity = $request->sender_identity[$i];
            $shipment->sender_phone = $request->sender_phone[$i];

            $shipment->receiver_name = $request->receiver_name[$i];
            $shipment->receiver_identity = $request->receiver_identity[$i];
            $shipment->receiver_phone = $request->receiver_phone[$i];

            $shipment->driver_name = $request->driver_name;
            $shipment->driver_identity = $request->driver_identity;
            $shipment->driver_phone = $request->driver_phone;

            $shipment->car_number = $request->car_number;
            if($request->note[$i] != ''){
                $shipment->note = $request->note[$i];
            }
            if(request()->file('image')){
                $file = request()->file('image');
                $destinationPath = 'images/shipment/';
                $filename = $file->getClientOriginalName();
                $file->move($destinationPath, $filename);
                $shipment->image = $filename;
            }
            if($shipment->save()){
                $shipment_price = new OutShipmentPrice();
                $shipment->add_by = $request->add_by;
                $shipment_price->out_shipment_id = $shipment->id;
                $shipment_price->transfer_price = $request->transfer_price[$i];
                $shipment_price->office_price = $request->office_price[$i];
                $shipment_price->our_price = $request->our_price[$i];
                $shipment_price->buy_type_id = $request->buy_type_id[$i];
                $shipment_price->tax = $request->tax[$i];
                $shipment_price->save();

                foreach($package as $pack) {
                    $count = 'count'. $pack->id;
                    if($request->has($count) && $request->$count[$i] != '' && $request->$count[$i] > 0) {

                        $shipment_package = new OutShipmentPackage();
                        $shipment_package->add_by = request('add_by');
                        $shipment_package->out_shipment_id = $shipment->id;
                        $shipment_package->package_type_id = $pack->id;
                        $shipment_package->count = $request->$count[$i];
                        $shipment_package->save();

                    }
                }

//  send sms

//                dd($request->sms_msg );

               if( $request->has('sms_msg') && $request->sms_msg != '')
               {

                   sendSMS($request->receiver_phone[$i], $request->sms_msg);

               }


            }
        }

        return redirect('admin/out-shipment/sheet/print?office=' . $request->office_id . '&car=' . $request->car_number )->with('created', 'تمت الاضافة بنجاح');
    }


    public function update($id, Request $request) {
        $this->validate($request, $this->validation_func());
        $shipment=$this->model->find($id);
        $shipment->add_by=request('add_by');
        $shipment->city_id=request('city_id');
        $shipment->office_id=request('office_id');
        $shipment->shipment_type_id=request('shipment_type_id');

        $shipment->sender_name= request('sender_name');
        $shipment->sender_identity=request('sender_identity');
        $shipment->sender_phone=request('sender_phone');

        $shipment->receiver_name=request('receiver_name');
        $shipment->receiver_identity=request('receiver_identity');
        $shipment->receiver_phone=request('receiver_phone');

        $shipment->driver_name=request('driver_name');
        $shipment->driver_identity=request('driver_identity');
        $shipment->driver_phone=request('driver_phone');

        $shipment->car_number=request('car_number');
        if(request('note')){
            $shipment->note=request('note');
        }
        if(request()->file('image')){
            $file = request()->file('image');
            $destinationPath = 'images/shipment/';
            $filename = $file->getClientOriginalName();
            $file->move($destinationPath, $filename);
            $shipment->image = $filename;
        }
        $shipment->update();

        $shipment_price= OutShipmentPrice::where('out_shipment_id',$shipment->id)->first();
        $shipment->add_by=request('add_by');
        $shipment_price->transfer_price=request('transfer_price');
        $shipment_price->office_price=request('office_price');
        $shipment_price->our_price=request('our_price');
        $shipment_price->buy_type_id=request('buy_type_id');
        $shipment_price->tax=request('tax');
        $shipment_price->update();
        $counts= request('count');
        $package_type_ids= request('package_type_ids');
        foreach ($package_type_ids as $key=>$package_type_id){
            if($counts[$key]>0){
                $shipment_package=OutShipmentPackage::where(['out_shipment_id'=>$shipment->id,'package_type_id'=>$package_type_id])->first();
                if(count($shipment_package)>0){
                    $shipment_package->add_by=request('add_by');
                    $shipment_package->out_shipment_id=$shipment->id;
                    $shipment_package->package_type_id=$package_type_id;
                    $shipment_package->count=$counts[$key];
                    $shipment_package->update();
                }else{
                    $shipment_package=new OutShipmentPackage();
                    $shipment_package->add_by=request('add_by');
                    $shipment_package->out_shipment_id=$shipment->id;
                    $shipment_package->package_type_id=$package_type_id;
                    $shipment_package->count=$counts[$key];
                    $shipment_package->save();
                }

            }
        }


        return redirect('admin/'.$this->route.'')->with('updated','تم التعديل بنجاح');
    }

    public function show_receipt($id)
    {
        $row = $this->model->find($id);
        return View('admin.out-shipment.show_receipt', compact('row'));
    }

    public function invoice_receipt($id)
    {
        $row = $this->model->find($id);
        return View('admin.out-shipment.invoice_receipt', compact('row'));
    }

    public function shipmentExported()
    {
        $rows = $this->model->where('delivery_status',1)->get();
        return view('admin.out-shipment.shipmentExported', compact('rows'));
    }

    public function print($id){

        $row = $this->model->where('id', $id)->first();

        $prices = OutShipmentPrice::where('out_shipment_id', $row->id)->first();
        $buyType = BuyType::where('id', $prices->buy_type_id)->first();

        $packageArr = OutShipmentPackage::where('out_shipment_id', $id)->join('package_types', 'shipment_packages.package_type_id', '=', 'package_types.id')->select('shipment_packages.count as count', 'package_types.id as id', 'package_types.name as name')->get();

        $pType = PackageType::select('id', 'name')->get();

        $packageData = [];
        $packageData['sum'] = 0;
        $packageData['count'] = '';
        $packageData['name'] = '';

        foreach($packageArr as $v) {

            $packageData['count'] = $v->count . '_' . $packageData['count'];
            $packageData['name'] = $v->name . '_' . $packageData['name'];

            $packageData['sum'] = $packageData['sum'] + $v->count;
        }

        return view('admin.out-shipment.print', compact('row', 'packageData', 'pType', 'prices', 'buyType'));

    }

    public function receiptSheetPrint(Request $request) {

        $office = (int) $request->office;
        $carNumber = (int) $request->car;

        $data = $this->model->where('delivery_status',0)->where('office_id', $office)->where('car_number', $carNumber)->where('mediator_name', null)->join('out_shipment_prices', 'out_shipments.id', '=', 'out_shipment_prices.out_shipment_id')->select('out_shipments.sender_name as from', 'out_shipments.receiver_name as to', 'out_shipment_prices.office_price as price', 'out_shipments.id as id', 'out_shipments.sender_phone as phone')->get();

        $info = $this->model->where('delivery_status',0)->where('office_id', $office)->where('car_number', $carNumber)->where('mediator_name', null)->join('offices', 'out_shipments.office_id', 'offices.id')->join('city_descriptions', 'out_shipments.city_id', '=', 'city_descriptions.city_id')->select('offices.name as o_name', 'city_descriptions.name as c_name', 'out_shipments.created_at as date', 'out_shipments.car_number as car_number','out_shipments.driver_phone as driver_phone', 'out_shipments.driver_identity as driver_identity', 'out_shipments.driver_name as driver_name')->first();

        return view('admin.out-shipment.receiptSheetPrint', compact('data', 'info'));

    }


    function postSms(Request $request) {

        $send = false;

        if($request->has('phone') && $request->has('message')) {

         $send = sendSMS($request->phone, $request->message);

        }
        if($send !== false) {
            return redirect()->route('sms')->with('updated', 'تم الارسال بنجاح');

        }
        return redirect()->route('sms')->with('updated', 'لم يتم الارسال حاول مرة اخري');

    }








}
