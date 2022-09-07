<?php

namespace App\Http\Controllers;

use App\Models\Branche;
use App\Models\Contact;
use App\Models\Jop;
use App\Models\Setting;
use App\Models\SettingDescription;
use App\Models\Shipment;
use Illuminate\Http\Request;
use Goutte;
use Illuminate\Support\Facades\Artisan;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $contacts = Setting::orderBy('created_at', 'DESC')->first();
        $jops = Jop::all();
        $branches = Branche::all();
        view()->share(array('contacts' => $contacts,'jops' => $jops,'branches' => $branches));
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $about = SettingDescription::orderBy('created_at', 'DESC')->first();
        return view('Site.index', compact('about'));
    }
    public function search(Request $request)
    {
        $ship_num = $request->ship_num;
        $mobile = $request->mobile;

        if(isset($request->ship_num) && $request->has('ship_num') && $request->ship_num != '') {
            $shipment = Shipment::where(['id' => $ship_num, 'receiver_phone' => $mobile])->first();
        } else {
            $shipment = Shipment::where(['receiver_phone' => $mobile])->orderBy('id', 'DESC')->first();
        }


        if($shipment){
            return view('Site.search', compact('shipment'));
        }
        return view('Site.search');
    }
    public function postSendContact(Request $request)
    {
        $this->validate($request, ['name' => 'required', 'mobile' => 'required|numeric', 'email' => 'required|email', 'content' => 'required']);
        $cont = new Contact();
        $cont->name = $request['name'];
        $cont->mobile = $request['mobile'];
        $cont->email = $request['email'];
        $cont->content = $request['content'];
        $cont->save();
        return back();
    }

    public function getCustomers()
    {
        $data = Branche::where('status', 'active')->join('branche_descriptions', 'branches.id', '=', 'branche_descriptions.branche_id')->select('branche_descriptions.branche_id as id', 'branche_descriptions.title as title', 'branche_descriptions.address as address', 'branches.image as image', 'branches.mobile as mobile')->get();

        return view('Site.customers', compact('data'));
    }
    public function service($id)
    {
        $jop=Jop::find($id);
        return view('Site.service',compact('jop'));
    }

}
