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
use App\Models\SubCategory;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;
use Analytics;
use Auth;
class BillController extends MasterController
{
    public function __construct(Bill $model)
    {
        $this->model = $model;
        $this->route = 'bill';
        $this->module_name         = 'قائمة السندات';
        $this->single_module_name  = 'سند';
        $this->index_fields        = ['عنوان السند' => 'name','قيمة السند' => 'price'];
        $this->create_fields        = ['عنوان السند' => 'name','قيمة السند' => 'price'];
        $this->update_fields        = ['عنوان السند' => 'name','قيمة السند' => 'price'];
        parent::__construct();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function validation_func()
    {
        $languages=Language::all();
        $therulesarray = [];
        $therulesarray['name'] = 'required';
        $therulesarray['price'] = 'required';
        $therulesarray['note'] = 'required';
        $therulesarray['image'] = 'mimes:png,jpg,jpeg';
        return $therulesarray;
    }

    public function getByType($type) {

        $data = Bill::where('type', $type)->get();

        return view('admin.bill.index-type', compact('data'));


    }

    public function store(Request $request) {
        $this->validate($request, $this->validation_func());
        $bill = new Bill();
        $bill->add_by=request('add_by');
        $bill->name=request('name');
        $bill->note=request('note');
        $bill->price=request('price');
        $bill->type = request('type');
        if(request()->file('image')){
            $file = request()->file('image');
            $destinationPath = 'images/bill/';
            $filename = $file->getClientOriginalName();
            $file->move($destinationPath, $filename);
            $bill->image = $filename;
        }
        $bill->save();
        return redirect('admin/'.$this->route.'')->with('created', 'تمت الاضافة بنجاح');
    }


    public function update($id, Request $request) {
        $this->validate($request, $this->validation_func());
        $bill=$this->model->find($id);
        $bill->add_by=request('add_by');
        if(request('name')){
            $bill->name=request('name');
        }
        if(request('note')){
            $bill->note=request('note');
        }
        if(request('price')){
            $bill->price=request('price');
        }
        if(request()->file('image')){
            $file = request()->file('image');
            $destinationPath = 'images/bill/';
            $filename = $file->getClientOriginalName();
            $file->move($destinationPath, $filename);
            $bill->image = $filename;
        }
        $bill->update();
        return redirect('admin/'.$this->route.'')->with('updated','تم التعديل بنجاح');
    }

    public function print($id) {

        $row = Bill::where('id', $id)->first();

        return view('admin.bill.print', compact('row'));

    } 

}
