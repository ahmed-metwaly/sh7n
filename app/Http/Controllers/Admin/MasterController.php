<?php
namespace App\Http\Controllers\Admin;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\City;
use App\Models\CityDescription;
use App\Models\Bill;
use App\Models\BuyType;
use App\Models\Contact;
use App\Models\Office;
use App\Models\PackageType;
use App\Models\Purchase;
use App\Models\Shipment;
use App\Models\ShipmentPackage;
use App\Models\ShipmentPrice;
use App\Models\ShipmentType;
use App\Models\Client;
use App\Models\Language;
use App\Models\Setting;
use App\User;
use ConsoleTVs\Charts\Facades\Charts;
use Illuminate\Http\Request;
use Auth;


abstract class MasterController extends Controller {

    protected $model;         // model name
    protected $other_model;         // other_model name
    protected $route;         // route name
    protected $perPage = 10;  // pagination
    protected $validation_c;  // validation on create
    protected $validation_u;  // validation on update
    protected $module_name;
    protected $single_module_name;
    protected $index_fields;
    protected $create_fields;
    protected $update_fields;

    public function __construct()
    {



        $cities_array = [];
        $cities=City::all();
        foreach ( $cities as $city) {
            $city_name=CityDescription::where(['language_id'=>1,'city_id'=>$city->id])->value('name');
            $cities_array[$city->id] = $city_name;
        }
        $shipment_types_array = [];
        $shipment_types=ShipmentType::all();
        foreach ( $shipment_types as $type) {
            $shipment_types_array[$type->id] = $type->name;
        }
        $buy_types_array = [];
        $buy_types = BuyType::all();
        foreach ( $buy_types as $type) {
            $buy_types_array[$type->id] = $type->name;
        }
        $office_array = [];
        $office=Office::all();
        foreach ( $office as $office) {
            $office_array[$office->id] = $office->name;
        }
        $this->middleware('auth:admin');
        view()->share(array(
            'module_name'        => $this->module_name,
            'single_module_name' => $this->single_module_name,
            'route'              => $this->route,
            'index_fields'       => $this->index_fields,
            'create_fields'      => $this->create_fields,
            'update_fields'      => $this->update_fields,
            'status'        => ['active'=>'مفعل','not_active'=>'غير مفعل'],
            'cities'        => $cities_array,
            'shipment_types'=> $shipment_types_array,
            'buy_types'=> $buy_types_array,
            'offices'=> $office_array,
            'package_types'=> PackageType::where('status','active')->get(),
            'type'        => ['receipt'=>'سند قبض','buy'=>' سند دفع','dept'=>'سند تسديد مديونية'],
            'mediator'        => ['in_office'=>'فى المكتب','out_office'=>'ارسال للعميل'],
            'languages'        => Language::all(),
            'setting'        => Setting::first(),
            'a_count'=>Admin::count(),
            'u_count'=>User::count(),
            'c_count'=>Client::count(),
            'ci_count'=>City::count(),
            'receipt_count'=>Bill::where('type','receipt')->count(),
            'buy_count'=>Bill::where('type','buy')->count(),
            'dept_count'=>Bill::where('type','dept')->count(),
            'bill_count'=>Bill::count(),
            'office_count'=>Office::count(),
            'package_type_count'=>PackageType::count(),
            'purchases_count'=>Purchase::count(),
            'shipments_count'=>Shipment::count(),
            'con_count'=>Contact::count(),
        ));

    }

	public function index() {


        checkLevel(Auth::user()->level_id);

        $rows = $this->model->latest()->get();
        return view('admin.'.$this->route.'.index', compact('rows'));
    }

    public function create() {
        checkLevel(Auth::user()->level_id);
        return view('admin.'.$this->route.'.create');
    }

    public function store(Request $request) {
        $this->validate($request, $this->validation_func(1));
        $this->model->create($request->all());
        return redirect('admin/'.$this->route.'')->with('created', 'تمت الاضافة بنجاح');
    }

    public function edit($id) {
        checkLevel(Auth::user()->level_id);
        $row = $this->model->find($id);
        return View('admin.'.$this->route.'.edit', compact('row'));
    }

    public function update($id, Request $request) {
        $this->validate($request, $this->validation_func(2,$id));
        $this->model->find($id)->update($request->all());
        return redirect('admin/'.$this->route.'')->with('updated','تم التعديل بنجاح');
    }

    public function destroy($id) {
        checkLevel(Auth::user()->level_id);
        $this->model->find($id)->delete();
        return redirect('admin/'.$this->route.'')->with('deleted','تم الحذف بنجاح');
    }

    public function show($id)
    {
        checkLevel(Auth::user()->level_id);
        $row = $this->model->find($id);
        return View('admin.'.$this->route.'.show', compact('row'));
    }
    public function Activate($id) {
        checkLevel(Auth::user()->level_id);
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

