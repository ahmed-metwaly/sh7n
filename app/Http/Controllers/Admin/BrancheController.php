<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\MasterController;
use App\Models\Admin;
use App\Models\BrancheImage;
use App\Models\Language;
use App\Models\BrancheDescription;
use App\Models\Branche;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;
use Analytics;
use Auth;
use Image;
class BrancheController extends MasterController
{
    public function __construct(Branche $model)
    {
        $this->model = $model;
        $this->route = 'branche';
        $this->module_name         = 'قائمة الفروع';
        $this->single_module_name  = 'فرع';
        $this->index_fields        = ['البريد الالكترونى' => 'email','الهاتف' => 'mobile'];
        $this->create_fields        = ['البريد الالكترونى' => 'email','الهاتف' => 'mobile'];
        $this->update_fields        = ['البريد الالكترونى' => 'email','الهاتف' => 'mobile'];
        parent::__construct();
    }


    public function validation_func()
    {
        $languages=Language::all();
        $therulesarray = [];
        foreach ( $languages as $language) {
            $therulesarray['address_'.$language->label] = 'required|max:255';
            $therulesarray['title_'.$language->label] = 'required|max:255';
        }
        $therulesarray['mobile'] = 'required';
        return $therulesarray;
    }

    public function store(Request $request) {
        // $this->validate($request, $this->validation_func());
        $branche = new Branche();
        $branche->status = request('status'); 

        $branche->image = uploading($request->file('image'), '/images/branche', ['450x450']);;


        $branche->mobile = request('mobile');
        $branche->save();

        $languages=Language::all();

        foreach ($languages as $language){
            $branche_description=new BrancheDescription();
            $branche_description->address=request('address_'.$language->label);
            $branche_description->title=request('title_'.$language->label);
            $branche_description->language_id=$language->id;
            $branche_description->branche_id=$branche->id;
            $branche_description->save();
        }
        return redirect('admin/'.$this->route.'')->with('created', 'تمت الاضافة بنجاح');
    }


    public function update($id, Request $request) {
        //$this->validate($request, $this->validation_func());

        $branche = Branche::find($id);
        if($request->has('status')) {

            $branche->status = request('status');

        }

        if($request->has('mobile')) {

            $branche->mobile = request('mobile');

        }

        if(request('image') && request('image') != ''){
            @unlink(public_path('images/branche_450x450') . '/' . $branche->image);

            $f = uploading($request->file('image'), '/images/branche', ['450x450']);
            
            $branche->image = $f;
        }
        $branche->save();



        $languages=Language::all();
        foreach ($languages as $language){
            $branche_description=BrancheDescription::where(['branche_id'=>$id,'language_id'=>$language->id])->first();
            if(isset($branche_description)){
                $branche_description->address=request('address_'.$language->label);
                $branche_description->title=request('title_'.$language->label);
                $branche_description->update();
            }else{
                $branche_description=new BrancheDescription();
                $branche_description->address=request('address_'.$language->label);
                $branche_description->title=request('title_'.$language->label);
                $branche_description->language_id=$language->id;
                $branche_description->branche_id=$branche->id;
                $branche_description->save();
            }
        }
        return redirect('admin/'.$this->route.'')->with('updated','تم التعديل بنجاح');
    }
}
