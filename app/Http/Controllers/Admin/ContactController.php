<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\MasterController;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends MasterController
{

    public function __construct(Contact $model)
    {
        $this->model = $model;
        $this->route = 'contact';
        $this->module_name = 'قائمة الرسائل';
        $this->single_module_name = 'الرسائل';
        parent::__construct();
    }


    public function index()
    {
        checkLevel(auth::user()->level_id);
        $contacts = Contact::all();
        return view('admin.contact.index', compact('contacts'));
    }
}
