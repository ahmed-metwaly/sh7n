<?php

namespace App\Http\Controllers\Admin;

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

class AdminController extends MasterController
{
    public function __construct(Admin $model)
    {

        $this->model = $model;
        $this->route = 'admin';
        $this->module_name = 'قائمة الادارة';
        $this->single_module_name = 'مدير';
        $this->index_fields = ['الاسم' => 'name', 'البريد الإلكترونى' => 'email', 'رقم الجوال' => 'mobile',];
        $this->create_fields = ['الاسم' => 'name', 'البريد الإلكترونى' => 'email', 'رقم الجوال' => 'mobile'];
        $this->update_fields = ['الاسم' => 'name', 'البريد الإلكترونى' => 'email', 'رقم الجوال' => 'mobile'];
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function dashboard()
    {
        checkLevel(auth::user()->level_id);
        return view($this->route . '.index');
    }

    public function edit_profile()
    {


        $row = Auth::user();
        return View($this->route . '.profile', compact('row'));
    }


    public function update_profile($id, Request $request)
    {

        $this->validate($request, $this->validation_func(2, $id));

        $this->model->find($id)->update($request->all());

        return redirect('admin/' . $this->route . '')->with('updated', 'تم التعديل بنجاح');
    }


    public function Activate($id)
    {
        $row = $this->model->find($id);
        if ($row->status == 'not_active') {
            $this->model->find($id)->update(['status' => 'active']);
            return back()->with('success', 'تم الغاء التفعيل بنجاح');
        } else {
            $this->model->find($id)->update(['status' => 'not_active']);
            return back()->with('success', 'تم التفعيل بنجاح');
        }
    }


    public function validation_func($method, $id = null)
    {

        if ($method == 1) // POST Case
            return ['level_id' => 'required', 'name' => 'required', 'mobile' => 'required|unique:admins', 'email' => 'email|max:255|unique:admins', 'image' => 'mimes:png,jpg,jpeg', 'password' => 'required|min:6'];
        return ['level_id' => 'required', 'name' => 'required', 'mobile' => 'required|unique:admins,mobile,' . $id, 'email' => 'email|max:255|unique:admins,email,' . $id, 'image' => 'mimes:png,jpg,jpeg'];
    }

}
