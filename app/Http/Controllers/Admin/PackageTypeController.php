<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\MasterController;
use App\Models\Ad;
use App\Models\Admin;
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
class PackageTypeController extends MasterController
{
    public function __construct(PackageType $model)
    {
        $this->model = $model;
        $this->route = 'package_type';
        $this->module_name         = 'قائمة أنواع الطرود';
        $this->single_module_name  = 'طرد';
        $this->index_fields        = ['الاسم' => 'name'];
        $this->create_fields        = ['الاسم' => 'name'];
        $this->update_fields        = ['الاسم' => 'name'];
        parent::__construct();
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
    public function validation_func()
    {
        $languages=Language::all();
        $therulesarray = [];
        $therulesarray['name'] = 'required';
        return $therulesarray;
    }

    public function store(Request $request) {
        $this->validate($request, $this->validation_func());
        $package_type=new PackageType();
        $package_type->add_by=request('add_by');
        $package_type->name=request('name');
        $package_type->status=request('status');
        $package_type->save();
        return redirect('admin/'.$this->route.'')->with('created', 'تمت الاضافة بنجاح');
    }


    public function update($id, Request $request) {
        $this->validate($request, $this->validation_func());
        $package_type=$this->model->find($id);
        $package_type->add_by=request('add_by');
        $package_type->status=request('status');
        $package_type->name=request('name');
        $package_type->update();
        return redirect('admin/'.$this->route.'')->with('updated','تم التعديل بنجاح');
    }




}
