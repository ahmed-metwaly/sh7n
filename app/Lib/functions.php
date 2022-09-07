<?php

function checkLevel($level_id) {



    $level_id = (int) $level_id;

    $data = \App\Models\ManagementLevel::find($level_id);


    if(isset($data->id)) {

        $route = \Request::route()->getName();

        $levels_all = json_decode($data->items, true);

        $levels = array_keys($levels_all);



        if( ! in_array($route, $levels)) {
            abort(403);
        }

    }


}

function setting()
{
    return \App\Models\Setting::first();
}

function countOrderItems($id)
{

    $pType = \App\Models\PackageType::select('id', 'name')->get();


    $packageArr = \App\Models\ShipmentPackage::where('shipment_id', $id)->join('package_types', 'shipment_packages.package_type_id', '=', 'package_types.id')->select('shipment_packages.count as count', 'package_types.id as id', 'package_types.name as name')->get();

    $packageData = '';

    $count = 0;

    foreach ($packageArr as $v) {
        if ($packageData != '') {

            $packageData .= ' + ';

        }

        $packageData .= $v->count . ' ' . $v->name;

        $count += $v->count;

    }

    return [$packageData, $count];


}


function sendSMS($toMobile, $message)
{


// http://sms.malath.net.sa/httpSmsProvider.aspx?username=mutwakil&password=kola1989&mobile=966543161756&unicode=U&message=مرحبا بك&sender=MutlaqCargo
//http://sms.malath.net.sa/apis/users.aspx?code=8&username=mutwakil&password=kola1989& mobile=966543161756&sender=MutlaqCargo=28/12/2011&Time=13:00&message=مرحبا&unicode=U

    require_once 'sms.class.php';

    $username = 'mutwakil';
    $password = 'kola1989';
    $Originator = 'MutlaqCargo';

    $DTT_SMS = new Malath_SMS($username, $password, 'UTF-8');

    $Credits = $DTT_SMS->GetCredits();
    $SenderName = $DTT_SMS->GetSenders();
    $CheckUser = $DTT_SMS->CheckUserPassword();

//    $DTT_SMS->CheckUserPassword($CheckUser);

    $remove = '';

    $usernumber = '';

    $trf = mb_substr($toMobile, 0, 5);

    if ($trf == '00966') {
        $trt = mb_substr($toMobile, 0, 1);

        if ($trt == '0') {
            $usernumber = mb_substr($toMobile, 5);
        } else {
            $usernumber = mb_substr($toMobile, 4);
        }

    } elseif (mb_substr($toMobile, 0, 1) == '0') {
        $usernumber = mb_substr($toMobile, 1);
    } else {
        $usernumber = mb_substr($toMobile, 3);
    }

    $send = $DTT_SMS->Send_SMS('00966,' . $usernumber, $Originator, $message);
    return $send;
}

function menu()
{
    return [
        [
            'title' => 'لوحة التحكم',
            'route' => [
                'admin.dashboard' => 'عرض لوحة التحكم',

            ]
        ],
        [
            'title' => 'الإعدادات',
            'route' => [
                'setting.get_setting' => 'عرض لوحة التحكم',

            ]
        ],
        [
            'title' => 'الإدارة',
            'route' => [
                'admin.index' => 'عرض المديرين',
                'admin.profile' => 'تعديل الملف الشخصي',
                'active_admin' => 'تفعيل مدير',
                'admin.create' => 'اضافة مدير',
                'admin.edit' => 'تعديل مدير',
                'admin.destroy' => 'حذف مدير',

            ]
        ],
        [
            'title' => 'مستويات الادارة',
            'route' => [
                'levels' => 'عرض مستويات الادارة',
                'level-add' => 'اضافة مستوي اداري',
                'level-edit' => 'تعديل مستوي اداري',
                'level-delete' => 'حذف مستوي اداري'
            ]
        ],

        [
            'title' => 'الرسائل',
            'route' => [
                'contact.index' => 'عرض الرسائل',
                'contact.destroy' => 'خذف الرسائل',
            ]
        ],
        [
            'title' => 'المدن',
            'route' => [
                'city.index' => 'عرض المدن',
                'city.add' => 'اضافة مدينة',
                'city.edit' => 'تعديل مدينة',
                'city.destroy' => 'خذف مدينة',
                'active_city' => 'تفعيل مدينة',
            ]
        ],
        [
            'title' => 'ارسال رسائل نصية للجوال',
            'route' => [
                'sms' => 'ارسال رسالة نصية',
            ],
        ],
        [
            'title' => 'وسائل التواصل',
            'route' => [
                'social.index' => 'عرض وسائل التواصل',
                'social.edit' => 'تعديل وسائل التواصل',
                'active_social' => 'تفعيل وسائل التواصل'
            ],
        ],
        [
            'title' => 'الخدمات',
            'route' => [
                'jop.index' => 'عرض الخدمات',
                'jop.edit' => 'تعديل  الخدمات',
                'jop.destroy' => 'حذف الخدمات  ',
                'active_jop' => 'تفعيل  الخدمات'
            ],
        ],
        [
            'title' => 'الوكلاء',
            'route' => [
                'branche.index' => 'عرض الوكلاء',
                'branche.edit' => 'تعديل  الوكلاء',
                'branche.destroy' => 'حذف الوكلاء  ',
                'active_branche' => 'تفعيل  الوكلاء'
            ],
        ],
        [
            'title' => 'الطرود',
            'route' => [
                'shipmentReceived' => 'الطرود الواردة',
                'shipmentExported' => 'الطرود الصادره',
                'shipment.create' => 'اضافة طرد',
                'shipmentReceiptSheet' => 'تصدير سند استلام',
                'shipment.index' => 'عرض الكل'
            ],
        ],

        [
            'title' => 'الشحنات',
            'route' => [
                'out-shipment.index' => 'عرض الشحنات',
                'out-shipment.create' => 'اضافة شحنه',
                'out-shipment.edit' => 'تعديل  الشحنات',
                'out-shipment.destroy' => 'حذف الشحنات  ',
            ],
        ],

        [
            'title' => 'الاقفال',
            'route' => [
                'ex.get' => 'عمليات الاقفال',
            ],
        ],

        [
            'title' => 'حساب الافراد',
            'route' => [
                'owe' => 'المدينون',
            ],
        ],
        [
            'title' => 'السندات',
            'route' => [
                'bill.create' => 'اضافة سند جديد',
                'bill.index' => 'عرض كل السندات'
            ],
        ],
        [
            'title' => 'المشتريات',
            'route' => [
                'purchase.create' => 'اضافة مشتري جديد',
                'purchase.index' => 'عرض كل المشتريات',
                'purchase.edit' => 'تعديل المشتريات',
                'purchase.destroy' => 'حذف المشتريات'
            ],
        ],

        [
            'title' => 'المكاتب',
            'route' => [
                'office.create' => 'اضافة مكتب جديد',
                'office.index' => 'عرض كل المكاتب',
                'active_office' => ' تفعيل المكاتب '
            ],
        ],

        [
            'title' => 'اساليب الدفع',
            'route' => [
                'buy_type.create' => 'اضافة جديد',
                'office.index' => 'عرض الكل ',
                'active_buy_type' => ' تفعيل  '
            ],
        ],
        [
            'title' => 'حاللات الطرود',
            'route' => [
                'shipment_type.create' => 'اضافة جديد',
                'shipment_type.index' => 'عرض الكل ',
                'active_shipment_type' => ' تفعيل  '
            ],
        ],
        [
            'title' => 'انواع الطرود',
            'route' => [
                'package_type.create' => 'اضافة جديد',
                'package_type.index' => 'عرض الكل ',
                'active_package_type' => ' تفعيل  '
            ],
        ],


    ];


}

function uploading($inputRequest, $folderNam, $resize = [])
{

    $imageName = time() . rand(0, 99) . '.' . $inputRequest->getClientOriginalExtension();

    if (!empty($resize)) {

        if (!is_dir(public_path($folderNam))) {
            mkdir(public_path($folderNam), 0777);
            chmod(public_path($folderNam), 0777);
        }

        foreach ($resize as $dimensions) {

            $destinationPath = public_path($folderNam . '_' . $dimensions);

            if (!is_dir($destinationPath)) {

                mkdir($destinationPath, 0777, true);
                chmod($destinationPath, 0777);

            }
            $img = Image::make($inputRequest->getRealPath());

            $dimension = explode('x', $dimensions);

            $img->resize($dimension[0], $dimension[1], function ($constraint) {

                $constraint->aspectRatio();

            });

            // $img->insert( 'public/web/images/logo-sm.png', 'bottom-right' );

            $img->save($destinationPath . DIRECTORY_SEPARATOR . $imageName);


        }

        return $imageName;

    }
}
