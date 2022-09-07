<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\MasterController;
use App\Models\Ad;
use App\Models\Admin;
use App\Models\Category;
use App\Models\City;
use App\Models\Client;
use App\Models\Country;
use App\Models\Product;
use App\Models\SubCategory;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;
use Analytics;
use Auth;
class ClientController extends MasterController
{
    public function __construct(Client $model)
    {
        $this->model = $model;
        $this->route = 'client';
        $this->module_name         = 'قائمة التجار';
        $this->single_module_name  = 'تاجر';
        $this->index_fields        = ['الاسم' => 'name','البريد الإلكترونى' => 'email','رقم الجوال' => 'mobile'];
        $this->create_fields        = ['الاسم' => 'name','البريد الإلكترونى' => 'email','رقم الجوال' => 'mobile'];
        $this->update_fields        = ['الاسم' => 'name','البريد الإلكترونى' => 'email','رقم الجوال' => 'mobile'];
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
    public function validation_func($method,$id=null)
    {
        if($method == 1) // POST Case
            return ['name' => 'required', 'mobile' => 'required|unique:clients','email'=>'email|max:255|unique:clients', 'image' => 'mimes:png,jpg,jpeg','password'=>'required|min:6'];
        return ['name' => 'required', 'mobile' => 'required|unique:clients,mobile,'.$id,'email'=>'email|max:255|unique:clients,email,'.$id, 'image' => 'mimes:png,jpg,jpeg'];
    }



}
