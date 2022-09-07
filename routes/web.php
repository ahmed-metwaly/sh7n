<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//use Analytics;
//use Spatie\Analytics\Period;

// echo bcrypt('123456');



Route::get('/', 'HomeController@index');
Route::post('/send-contact', 'HomeController@postSendContact')->name('SENT_CONTACT');
Route::post('/search', 'HomeController@search')->name('search');
Route::get('/customers', 'HomeController@getCustomers')->name('CUSTOMERS');
Route::get('/service/{id}', 'HomeController@service')->name('service');
//Route::get('/',function (){
//    return Analytics::fetchVisitorsAndPageViews(Period::days(7));
//
//});
Route::get('logout', 'Auth\LoginController@logout');
//Auth::routes();

//admin password reset routes
Route::group(['prefix' => '/admin', 'namespace' => 'Auth'], function () {
    Route::get('/password/reset', 'AdminForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
    Route::post('/password/email', 'AdminForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
    Route::post('/password/reset', 'AdminResetPasswordController@reset');
    Route::get('/password/reset/{token}', 'AdminResetPasswordController@showResetForm')->name('admin.password.reset');


});

Route::group(['prefix' => '/admin', 'namespace' => 'Admin'], function () {

    //auth
    Route::get('/login', 'AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'AdminLoginController@login')->name('admin.login.submit');
    Route::get('logout/', 'AdminLoginController@logout')->name('admin.logout');

    //dashboard
    Route::get('/', 'AdminController@dashboard')->name('admin.dashboard');

    Route::get('/profile', 'AdminController@edit_profile')->name('edit_profile');

    Route::get('setting', 'SettingController@get_setting')->name('setting.get_setting');
    Route::patch('setting/{id}', 'SettingController@update_setting')->name('setting.update_setting');

    Route::resource('admin', 'AdminController');
    Route::post('admin/activate/{id}', 'AdminController@activate')->name('active_admin');

    Route::resource('client', 'ClientController');
    Route::post('client/activate/{id}', 'ClientController@activate')->name('active_client');

    Route::resource('user', 'UserController');
    Route::post('user/activate/{id}', 'UserController@activate')->name('active_user');

    Route::resource('city', 'CityController');
    Route::post('city/activate/{id}', 'CityController@activate')->name('active_city');

    Route::resource('office', 'OfficeController');
    Route::post('office/activate/{id}', 'OfficeController@activate')->name('active_office');

    Route::resource('buy_type', 'BuyTypeController');
    Route::post('buy_type/activate/{id}', 'BuyTypeController@activate')->name('active_buy_type');

    Route::resource('package_type', 'PackageTypeController');
    Route::post('package_type/activate/{id}', 'PackageTypeController@activate')->name('active_package_type');

    Route::resource('shipment_type', 'ShipmentTypeController');
    Route::post('shipment_type/activate/{id}', 'ShipmentTypeController@activate')->name('active_shipment_type');

    Route::resource('bill', 'BillController');
    Route::get('bill-type/{type}', 'BillController@getByType')->name('bill-type');
    Route::get('bill-print/{id}', 'BillController@print')->name('bill-print');
    Route::resource('purchase', 'PurchaseController');
    Route::get('purchase-print/{id}', 'PurchaseController@print')->name('purchase-print');

    // out

    Route::resource('out-shipment', 'OutShipmentController');

    Route::resource('shipment', 'ShipmentController');
    Route::get('shipment/receipt/{id}', 'ShipmentController@show_receipt')->name('shipment.show_receipt');
    Route::get('shipment/invoice_receipt/{id}', 'ShipmentController@invoice_receipt')->name('shipment.invoice_receipt');

    Route::get('/receipt-print/{id}', 'ShipmentController@print')->name('receipt-print');


    Route::get('ex', 'ShipmentController@getEx')->name('ex.get');

    Route::get('owe', 'ShipmentController@getOwe')->name('owe');
    Route::get('/s-owe/{phone}/{price}', 'ShipmentController@sdad')->name('s-owe');

    Route::get('/owe-print/{id}', 'ShipmentController@owePrint')->name('owe-print');

    Route::post('sad-owe', 'ShipmentController@sadadOwe')->name('sad-owe');

    Route::get('shipment/sent/{id}', 'ShipmentController@show_sent')->name('shipment.show_sent');
    Route::get('shipment/invoice_sent/{id}', 'ShipmentController@invoice_sent')->name('shipment.invoice_sent'); //
    Route::get('shipment_receipt/{id}', 'ShipmentController@shipment_send')->name('shipment.send');
    Route::patch('send/{id}', 'ShipmentController@send_store')->name('shipment.send_store');
    Route::get('shipment-received', 'ShipmentController@shipmentReceived')->name('shipmentReceived');
    Route::get('shipment-exported', 'ShipmentController@shipmentExported')->name('shipmentExported');

    Route::get('/shipment-sheet', 'ShipmentController@getReceiptSheet')->name('shipmentReceiptSheet');

    Route::get('/shipment/sheet/print', 'ShipmentController@receiptSheetPrint')->name('receiptSheetPrint');

    Route::get('/out-shipment/sheet/print', 'OutShipmentController@ex')->name('outReceiptSheetPrint');


    Route::resource('language', 'LanguageController');
    Route::post('language/activate/{id}', 'LanguageController@activate')->name('active_language');

    Route::resource('branche', 'BrancheController');
    Route::post('branche-add', 'BrancheController@store')->name('branche-add');

    Route::post('branche/activate/{id}', 'BrancheController@activate')->name('active_branche');

    Route::resource('social', 'SocialController');
    Route::post('social/activate/{id}', 'SocialController@activate')->name('active_social');
    Route::resource('contact', 'ContactController');
    Route::resource('jop', 'JopController');
    Route::post('jop/activate/{id}', 'JopController@activate')->name('active_jop');

    Route::get('/send-sms', 'ShipmentController@sms')->name('sms');

    Route::post('/post-sms', 'ShipmentController@postSms')->name('post-sms');


    Route::group(['prefix' => 'groups'], function () {

        Route::get('/', [
            'uses' => 'ManagementLevelController@getIndex',
            'as' => 'levels'
        ]);

        Route::get('level-add', [
            'uses' => 'ManagementLevelController@getAdd',
            'as' => 'level-add'
        ]);

        Route::post('level-do-add', [
            'uses' => 'ManagementLevelController@postAdd',
            'as' => 'level-do-add'
        ]);

        Route::get('level-edit/{id}', [
            'uses' => 'ManagementLevelController@getEdit',
            'as' => 'level-edit'
        ]);

        Route::post('level-do-edit/{id}', [
            'uses' => 'ManagementLevelController@postEdit',
            'as' => 'level-do-edit'
        ]);

        Route::get('level-delete/{id}', [
            'uses' => 'ManagementLevelController@getDelete',
            'as' => 'level-delete'
        ]);

        Route::get('level-details/{id}', [
            'uses' => 'ManagementLevelController@getDetails',
            'as' => 'level-details'
        ]);

        Route::post('/delete-all/{route}', [
            'uses' => 'ManagementLevelController@deleteAll',
            'as' => 'lv-delete-all'
        ]);

    });


});


Route::get('/sendsms/{phone}', function ($phone) {

    $send = sendSMS($phone, 'hi hi');
    dd($send);

});





