<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\MasterController;
use App\Models\Ad;
use App\Models\Admin;
use App\Models\Bill;
use App\Models\BuyType;
use App\Models\Category;
use App\Models\City;
use App\Models\CityDescription;
use App\Models\Client;
use App\Models\Country;
use App\Models\Language;
use App\Models\PackageType;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Shipment;
use App\Models\ShipmentPackage;
use App\Models\ShipmentPrice;
use App\Models\SubCategory;
use App\Models\Office;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

//use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;
use Analytics;
use Auth;
class ShipmentController extends MasterController
{
    public function __construct(Shipment $model)
    {

        $this->model = $model;
        $this->route = 'shipment';
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

    public function shipment_send($id) {

        $row = $this->model->find($id);

        return View('admin.shipment.send', compact('row'));

    }

    public function store(Request $request) {


        $this->validate($request, $this->validation_func());

        $package = PackageType::select('id')->get();

        for($i = 0; $i < count($request->sender_identity); $i++) {


            $shipment = new Shipment();

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
                $shipment_price = new ShipmentPrice();
                $shipment->add_by = $request->add_by;
                $shipment_price->shipment_id = $shipment->id;
                $shipment_price->transfer_price = $request->transfer_price[$i];
                $shipment_price->office_price = $request->office_price[$i];
                $shipment_price->our_price = $request->our_price[$i];
                $shipment_price->buy_type_id = $request->buy_type_id[$i];
                $shipment_price->tax = $request->tax[$i];
                $shipment_price->save();

                foreach($package as $pack) {
                    $count = 'count'. $pack->id;
                    if($request->has($count) && $request->$count[$i] != '' && $request->$count[$i] > 0) {

                        $shipment_package = new ShipmentPackage();
                        $shipment_package->add_by = request('add_by');
                        $shipment_package->shipment_id = $shipment->id;
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

        return redirect('admin/shipment/sheet/print?office=' . $request->office_id . '&car=' . $request->car_number )->with('created', 'تمت الاضافة بنجاح');
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

        $shipment_price=ShipmentPrice::where('shipment_id',$shipment->id)->first();
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
                $shipment_package=ShipmentPackage::where(['shipment_id'=>$shipment->id,'package_type_id'=>$package_type_id])->first();
                if(count($shipment_package)>0){
                    $shipment_package->add_by=request('add_by');
                    $shipment_package->shipment_id=$shipment->id;
                    $shipment_package->package_type_id=$package_type_id;
                    $shipment_package->count=$counts[$key];
                    $shipment_package->update();
                }else{
                    $shipment_package=new ShipmentPackage();
                    $shipment_package->add_by=request('add_by');
                    $shipment_package->shipment_id=$shipment->id;
                    $shipment_package->package_type_id=$package_type_id;
                    $shipment_package->count=$counts[$key];
                    $shipment_package->save();
                }

            }
        }


        return redirect('admin/'.$this->route.'')->with('updated','تم التعديل بنجاح');
    }
    public function send_store($id) {
        $shipment=$this->model->find($id);
        $shipment->mediator_name=request('mediator_name');
        $shipment->mediator_identity=request('mediator_identity');
        $shipment->mediator_phone=request('mediator_phone');
        if(request('car_mediator_num')){
            $shipment->car_mediator_num=request('car_mediator_num');
            $shipment->car_mediator_name=request('car_mediator_name');
            $shipment->car_mediator_identity=request('car_mediator_identity');
            $shipment->car_mediator_phone=request('car_mediator_phone');
            $shipment->mediator_address=request('mediator_address');
            $shipment->mediator_price=request('mediator_price');
        }
        if(request()->file('mediator_signature')){
            $file = request()->file('mediator_signature');
            $destinationPath = 'images/shipment/';
            $filename = $file->getClientOriginalName();
            $file->move($destinationPath, $filename);
            $shipment->mediator_signature = $filename;
        }
        $shipment->update();
        return redirect('admin/'.$this->route.'')->with('updated','تم الاضافة بنجاح');
    }
    public function show_receipt($id)
    {
        $row = $this->model->find($id);
        return View('admin.shipment.show_receipt', compact('row'));
    }
    public function invoice_receipt($id)
    {
        $row = $this->model->find($id);
        return View('admin.shipment.invoice_receipt', compact('row'));
    }
    public function show_sent($id)
    {
        $row = $this->model->find($id);
        return View('admin.shipment.show_sent', compact('row'));
    }
    public function invoice_sent($id)
    {
        $row = $this->model->find($id);

        $packageArr = ShipmentPackage::where('shipment_id', $id)->join('package_types', 'shipment_packages.package_type_id', '=', 'package_types.id')->select('shipment_packages.count as count', 'package_types.id as id')->get();

        $pType = PackageType::select('id', 'name')->get();

        $packageData = [];
        $packageData['sum'] = 0;

        foreach($packageArr as $v) {
            $packageData[$v->id] = $v->count;
            $packageData['sum'] = $packageData['sum'] + $v->count;
        }



        return View('admin.shipment.invoice_sent', compact('row', 'packageData', 'pType'));
    }

     public function shipmentReceived()
    {
        $rows = $this->model->where('delivery_status',0)->where('mediator_name', null)->get();

        return view('admin.shipment.shipmentReceived', compact('rows'));
    }
    public function shipmentExported()
    {
        $rows = $this->model->where('delivery_status',1)->get();
        return view('admin.shipment.shipmentExported', compact('rows'));
    }

    public function print($id){

        $row = $this->model->where('id', $id)->first();

        $prices = ShipmentPrice::where('shipment_id', $row->id)->first();
        $buyType = BuyType::where('id', $prices->buy_type_id)->first();

        $packageArr = ShipmentPackage::where('shipment_id', $id)->join('package_types', 'shipment_packages.package_type_id', '=', 'package_types.id')->select('shipment_packages.count as count', 'package_types.id as id', 'package_types.name as name')->get();

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


// dd($packageData);
        return view('admin.shipment.print', compact('row', 'packageData', 'pType', 'prices', 'buyType'));

    }

    public function getReceiptSheet() {

        $offices = Office::where('status', 'active')->select('id', 'name')->get();

        return view('admin.shipment.receiptSheet', compact('offices'));

    }

    public function receiptSheetPrint(Request $request) {

        $office = (int) $request->office;
        $carNumber = (int) $request->car;

        $data = $this->model->where('delivery_status',0)->where('office_id', $office)->where('car_number', $carNumber)->where('mediator_name', null)->join('shipment_prices', 'shipments.id', '=', 'shipment_prices.shipment_id')->select('shipments.sender_name as from', 'shipments.receiver_name as to', 'shipment_prices.office_price as price', 'shipments.id as id', 'shipments.sender_phone as phone')->get();
        ;

        $info = $this->model->where('delivery_status',0)->where('office_id', $office)->where('car_number', $carNumber)->where('mediator_name', null)->join('offices', 'shipments.office_id', 'offices.id')->join('city_descriptions', 'shipments.city_id', '=', 'city_descriptions.city_id')->select('offices.name as o_name', 'city_descriptions.name as c_name', 'shipments.created_at as date', 'shipments.car_number as car_number','shipments.driver_phone as driver_phone', 'shipments.driver_identity as driver_identity', 'shipments.driver_name as driver_name')->first();

        return view('admin.shipment.receiptSheetPrint', compact('data', 'info'));

    }

    public function getEx(Request $request) {

        checkLevel(auth::user()->level_id);

        $data = [];
        $bill = [];
        $purchase = [];
        $rFrom = '';
        $rTo = '';

        if($request->has('from') && $request->has('to')) {

            $rFrom = $request->from;
            $rTo = $request->to;
            $to = date('Y-m-d H:m:s', strtotime($request->to));
            $from = date('Y-m-d H:m:s', strtotime($request->from));

            $data = Shipment::join('shipment_prices', 'shipments.id', '=', 'shipment_prices.shipment_id')->join('offices', 'shipments.office_id', '=', 'offices.id')->join('buy_types', 'shipments.shipment_type_id', '=', 'buy_types.id')->whereBetween('shipments.created_at', [$from, $to])->select('shipments.id as id', 'shipments.created_at as created_at', 'shipments.sender_name as from', 'shipments.receiver_name as to', 'offices.name as o_name', 'shipment_prices.transfer_price as transfer_price', 'shipment_prices.office_price as office_price', 'shipment_prices.our_price as our_price', 'shipments.mediator_price as mediator_price', 'buy_types.name as b_name' )->get();


            $bill = Bill::whereBetween('created_at', [$from, $to])->select('id', 'name', 'price', 'type')->get();

            $purchase = Purchase::whereBetween('created_at', [$from, $to])->select('id', 'name', 'price', 'count')->get();

        }

        $offices = Office::where('status', 'active')->select('id', 'name')->get();

        return view('admin.shipment.get_ex', compact('data', 'offices', 'bill', 'purchase', 'rFrom', 'rTo'));

    }

    public function getOwe(Request $request){
        checkLevel(auth::user()->level_id);
        $rFrom = $request->from;
        $rTo = $request->to;
        $to = date('Y-m-d H:m:s', strtotime($request->to));
        $from = date('Y-m-d H:m:s', strtotime($request->from));

        $rows = [];

if($request->has('phone')) {

        $rows = Shipment::join('shipment_prices', 'shipments.id', '=', 'shipment_prices.shipment_id')->join('owe', 'shipments.receiver_phone', '=', 'owe.phone', 'LEFT')->where('shipment_prices.buy_type_id', 3)->whereBetween('shipments.created_at', [$from, $to])->where('shipments.receiver_phone', $request->phone)->select('shipments.receiver_name as name', 'shipments.receiver_phone as phone', 'shipment_prices.transfer_price as transfer_price', 'shipment_prices.office_price as office_price', 'shipment_prices.our_price as our_price', 'shipments.mediator_price as mediator_price', 'owe.price as owe', 'shipments.id as id')->get();

    }


        return view('admin.shipment.owe', compact('rows'));

    }

    public function sdad($phone, $price) {

        return view('admin.shipment.sadad', compact('phone', 'price'));
    }

    public function sadadOwe(Request $request) {

       $phone = $request->phone;
       $price = (int) $request->price;
       $owe = $request->owe;

       $price = $price - $owe;

       $id = DB::table('owe')->insertGetId(['phone' => $phone, 'price'=> $price]);

       return redirect()->route("owe-print", $id);

    }

    public function owePrint($id) {

        $data = DB::table('owe')->where('id', $id)->first();

        return view('admin.shipment.owe-print', compact('data'));
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

    function sms() {

        return view('admin.shipment.sms');
    }






}
