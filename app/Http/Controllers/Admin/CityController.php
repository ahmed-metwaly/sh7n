<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\MasterController;
use App\Models\Ad;
use App\Models\Admin;
use App\Models\Category;
use App\Models\City;
use App\Models\CityDescription;
use App\Models\Client;
use App\Models\Country;
use App\Models\Language;
use App\Models\Product;
use App\Models\SubCategory;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;
use Analytics;
use Auth;
class CityController extends MasterController
{
    public function __construct(City $model)
    {
        $this->model = $model;
        $this->route = 'city';
        $this->module_name         = 'قائمة المدن';
        $this->single_module_name  = 'مدينة';
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
        foreach ( $languages as $language) {
            $therulesarray['name_'.$language->label] = 'required|max:255';
        }
        return $therulesarray;
    }

    public function store(Request $request) {
        $this->validate($request, $this->validation_func());
        $city=new City();
        $city->add_by=request('add_by');
        $city->status=request('status');
        $city->save();

        $languages=Language::all();
        foreach ($languages as $language){
            $city_description=new CityDescription();
            $city_description->name=request('name_'.$language->label);
            $city_description->language_id=$language->id;
            $city_description->city_id=$city->id;
            $city_description->save();
        }

        return redirect('admin/'.$this->route.'')->with('created', 'تمت الاضافة بنجاح');
    }


    public function update($id, Request $request) {
        $this->validate($request, $this->validation_func());
        $city=$this->model->find($id);
        $city->status=request('status');
        $city->update();
        $languages=Language::all();
        foreach ($languages as $language){
            $city_description=CityDescription::where(['city_id'=>$id,'language_id'=>$language->id])->first();
            if(isset($city_description)){
                $city_description->name=request('name_'.$language->label);
                $city_description->update();
            }else{
                $city_description=new CityDescription();
                $city_description->name=request('name_'.$language->label);
                $city_description->language_id=$language->id;
                $city_description->city_id=$city->id;
                $city_description->save();
            }

        }

        return redirect('admin/'.$this->route.'')->with('updated','تم التعديل بنجاح');
    }



}
