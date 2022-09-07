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
use App\Models\SubCategory;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;
use Analytics;
use Auth;
class PurchaseController extends MasterController
{
    public function __construct(Purchase $model)
    {
        $this->model = $model;
        $this->route = 'purchase';
        $this->module_name         = 'قائمة المشتريات';
        $this->single_module_name  = 'مشترى';
        $this->index_fields        = ['عنوان المشترى' => 'name','العدد' => 'count','التكلفة' => 'price'];
        $this->create_fields        = ['عنوان المشترى' => 'name','العدد' => 'count','التكلفة' => 'price'];
        $this->update_fields        = ['عنوان المشترى' => 'name','العدد' => 'count','التكلفة' => 'price'];
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
        $therulesarray['name'] = 'required';
        $therulesarray['price'] = 'required|numeric';
        $therulesarray['count'] = 'required|numeric';
        $therulesarray['note'] = 'required';
        $therulesarray['image'] = 'mimes:png,jpg,jpeg';
        return $therulesarray;
    }

    public function store(Request $request) {
        $this->validate($request, $this->validation_func());
        $purchase=new Purchase();
        $purchase->add_by=request('add_by');
        $purchase->name=request('name');
        $purchase->note=request('note');
        $purchase->price=request('price');
        $purchase->count=request('count');
        if(request()->file('image')){
            $file = request()->file('image');
            $destinationPath = 'images/purchase/';
            $filename = $file->getClientOriginalName();
            $file->move($destinationPath, $filename);
            $purchase->image = $filename;
        }
        $purchase->save();
        return redirect('admin/'.$this->route.'')->with('created', 'تمت الاضافة بنجاح');
    }


    public function update($id, Request $request) {
        $this->validate($request, $this->validation_func());
        $purchase=$this->model->find($id);
        $purchase->add_by=request('add_by');
        if(request('name')){
            $purchase->name=request('name');
        }
        if(request('note')){
            $purchase->note=request('note');
        }
        if(request('price')){
            $purchase->price=request('price');
        }
        if(request('count')){
            $purchase->count=request('count');
        }
        if(request()->file('image')){
            $file = request()->file('image');
            $destinationPath = 'images/purchase/';
            $filename = $file->getClientOriginalName();
            $file->move($destinationPath, $filename);
            $purchase->image = $filename;
        }
        $purchase->update();
        return redirect('admin/'.$this->route.'')->with('updated','تم التعديل بنجاح');
    }

    public function print($id)
    {
        $row = Purchase::where('id', $id)->first();

        return view('admin.bill.print', compact('row'));
    }


}
