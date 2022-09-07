<?php

namespace App\Http\Controllers\Admin;

use App\Models\Language;
use App\Models\Setting;
use Analytics;
use App\Models\SettingDescription;
use Auth;
use Symfony\Component\HttpFoundation\Request;

class SettingController extends MasterController
{
    public function __construct(Setting $model)
    {
        $this->model = $model;
        $this->route = 'setting';
        $this->module_name         = 'قائمة الاعدادات';
        $this->index_fields        = ['رقم الجوال الأول' => 'mobile_1','رقم الجوال الثانى' => 'mobile_2','البريد الإلكترونى' => 'email','عمولة الموقع' => 'commission'];
        $this->create_fields        = ['رقم الجوال الأول' => 'mobile_1','رقم الجوال الثانى' => 'mobile_2','البريد الإلكترونى' => 'email','عمولة الموقع' => 'commission'];
        $this->update_fields        = ['رقم الجوال الأول' => 'mobile_1','رقم الجوال الثانى' => 'mobile_2','البريد الإلكترونى' => 'email','عمولة الموقع' => 'commission'];
        parent::__construct();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function get_setting() {
        checkLevel(auth::user()->level_id);
        $row = $this->model->first();
        return View('admin.setting',compact('row'));
    }

    public function update_setting($id,Request $request) {
        $this->validate($request, $this->validation_func());
        $setting=$this->model->find($id);
        $setting->mobile_1=request('mobile_1');
        $setting->mobile_2=request('mobile_2');
        $setting->email=request('email');
        $setting->address=request('address');
        $setting->commission=request('commission');
        if(request()->file('logo')){
            $file = request()->file('logo');
            $destinationPath = 'public/images/logo/';
            $filename = $file->getClientOriginalName();
            $file->move($destinationPath, $filename);
            $setting->logo = $filename;
        }

        if(request()->file('print')){
            $file = request()->file('print');
            $destinationPath = 'public/images/logo/';
            $filename = $file->getClientOriginalName();
            $file->move($destinationPath, $filename);
            $setting->print = $filename;
        }

        $setting->update();
        $languages=Language::all();
        foreach ($languages as $language){
            $setting_description=SettingDescription::where(['setting_id'=>$id,'language_id'=>$language->id])->first();
            if(isset($setting_description)){
                $setting_description->name=request('name_'.$language->label);
                $setting_description->about=request('about_'.$language->label);
                $setting_description->update();
            }else{
                $setting_description=new SettingDescription();
                $setting_description->name=request('name_'.$language->label);
                $setting_description->about=request('about_'.$language->label);
                $setting_description->language_id=$language->id;
                $setting_description->setting_id=$setting->id;
                $setting_description->save();
            }
        }
        return redirect('admin/'.$this->route.'')->with('updated','تم التعديل بنجاح');
    }
    public function validation_func()
    {
        $languages=Language::all();
        $therulesarray = [];
        foreach ( $languages as $language) {
            $therulesarray['name_'.$language->label] = 'required|max:255';
            $therulesarray['about_'.$language->label] = 'required|max:255';
        }
        $therulesarray['logo'] = 'mimes:png,jpg,jpeg';
        $therulesarray['mobile_1'] = 'required';
        $therulesarray['mobile_2'] = 'required';
        $therulesarray['email'] = 'required';
        $therulesarray['commission'] = 'required';
        return $therulesarray;
    }

}
