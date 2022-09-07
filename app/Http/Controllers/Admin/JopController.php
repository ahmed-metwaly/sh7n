<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\MasterController;
use App\Models\Admin;
use App\Models\Client;
use App\Models\Language;
use App\Models\JopDescription;
use App\Models\Jop;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;
use Analytics;
use Auth;
class JopController extends MasterController
{
    public function __construct(Jop $model)
    {
        $this->model = $model;
        $this->route = 'jop';
        $this->module_name         = 'قائمة الوظائف';
        $this->single_module_name  = 'وظيفة';
        parent::__construct();
    }
    public function validation_func()
    {
        $languages=Language::all();
        $therulesarray = [];
        foreach ( $languages as $language) {
            $therulesarray['title_'.$language->label] = 'required';
            $therulesarray['note_'.$language->label] = 'required';
        }
        $therulesarray['image'] = 'required|mimes:png,jpg,jpeg';
        return $therulesarray;
    }
    public function store(Request $request) {
        $this->validate($request, $this->validation_func());
        $jop=new jop();
        $jop->add_by=request('add_by');
        $jop->status=request('status');
        if(request('image')){
            $jop->image=request('image');
        }
        $jop->save();
        $languages=Language::all();
        foreach ($languages as $language){
            $jop_description=new JopDescription();
            $jop_description->title=request('title_'.$language->label);
            $jop_description->note=request('note_'.$language->label);
            $jop_description->language_id=$language->id;
            $jop_description->jop_id=$jop->id;
            $jop_description->save();
        }
        return redirect('admin/'.$this->route.'')->with('created', 'تمت الاضافة بنجاح');
    }

    public function update($id, Request $request) {
        $this->validate($request, $this->validation_func());
        $jop=$this->model->find($id);
//        $jop->status=request('status');
        if(request('image')){
            $jop->image=request('image');
        }
        $jop->update();
        $languages=Language::all();
        foreach ($languages as $language){
            $jop_description=JopDescription::where(['jop_id'=>$id,'language_id'=>$language->id])->first();
            if(isset($jop_description)){
                $jop_description->title=request('title_'.$language->label);
                $jop_description->note=request('note_'.$language->label);
                $jop_description->update();
            }else{
                $jop_description=new JopDescription();
                $jop_description->title=request('title_'.$language->label);
                $jop_description->note=request('note_'.$language->label);
                $jop_description->language_id=$language->id;
                $jop_description->jop_id=$jop->id;
                $jop_description->save();
            }

        }
        return redirect('admin/'.$this->route.'')->with('updated','تم التعديل بنجاح');
    }
}
