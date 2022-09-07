<?php

namespace App\Http\Controllers\Admin;

use App\Models\Ad;
use App\Models\Admin;
use App\Models\Category;
use App\Models\City;
use App\Models\Client;
use App\Models\Country;
use App\Models\Office;
use App\Models\Product;
use App\Models\SubCategory;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;
use Analytics;
use Auth;
class OfficeController extends MasterController
{
    public function __construct(Office $model)
    {
        $this->model = $model;
        $this->route = 'office';
        $this->module_name         = 'قائمة المكاتب';
        $this->single_module_name  = 'مكتب';
        $this->index_fields        = ['اسم المكتب' => 'name','الهاتف الأول' => 'mobile_1','الهاتف الثانى' => 'mobile_2','البريد الالكترونى' => 'email'];
        $this->create_fields        = ['اسم المكتب' => 'name','الهاتف الأول' => 'mobile_1','الهاتف الثانى' => 'mobile_2','البريد الالكترونى' => 'email'];
        $this->update_fields        = ['اسم المكتب' => 'name','الهاتف الأول' => 'mobile_1','الهاتف الثانى' => 'mobile_2','البريد الالكترونى' => 'email'];
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
        $therulesarray['mobile_1'] = 'required';
        $therulesarray['city_id'] = 'required';
        $therulesarray['email'] = 'email';
        return $therulesarray;
    }

    public function store(Request $request) {
        $this->validate($request, $this->validation_func());
        $office=new Office();
        $office->add_by=request('add_by');
        $office->name=request('name');
        $office->status=request('status');
        $office->city_id=request('city_id');
        $office->mobile_1=request('mobile_1');
        $office->email=request('email');
        if(request('mobile_2')){
            $office->mobile_2=request('mobile_2');
        }
        $office->save();
        return redirect('admin/'.$this->route.'')->with('created', 'تمت الاضافة بنجاح');
    }


    public function update($id, Request $request) {
        $this->validate($request, $this->validation_func());
        $purchase=$this->model->find($id);
        $purchase->add_by=request('add_by');
        $purchase->city_id=request('city_id');
        if(request('name')){
            $purchase->name=request('name');
        }
        if(request('mobile_1')){
            $purchase->mobile_1=request('mobile_1');
        }
        if(request('mobile_2')){
            $purchase->mobile_2=request('mobile_2');
        }
        if(request('email')){
            $purchase->email=request('email');
        }
        $purchase->update();
        return redirect('admin/'.$this->route.'')->with('updated','تم التعديل بنجاح');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function Activate($id) {
        $row = $this->model->find($id);
        if($row->status == 'not_active') {
            $this->model->find($id)->update(['status' => 'active']);
            return back()->with('success' ,'تم الغاء التفعيل بنجاح');
        }
        else{
            $this->model->find($id)->update(['status' => 'not_active']);
            return back()->with('success' , 'تم التفعيل بنجاح');
        }
    }




}
