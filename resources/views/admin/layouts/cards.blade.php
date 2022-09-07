<div class="row">
    <div class="col-lg-3 col-sm-6">
        <a href="{{ route('bill-type', 'receipt') }}">
            <div class="widget-panel widget-style-2 bg-white">
                <i class="md md-attach-money text-primary"></i>
                <h2 class="m-0 text-dark counter font-600">{{$receipt_count}}</h2>
                <div class="text-muted m-t-5">سندات القبض</div>
            </div>
        </a>
    </div>
    <div class="col-lg-3 col-sm-6">
        <a href="{{ route('bill-type', 'buy') }}">
        <div class="widget-panel widget-style-2 bg-white">
            <i class="md md-add-shopping-cart text-primary"></i>
            <h2 class="m-0 text-dark counter font-600">{{$buy_count}}</h2>
            <div class="text-muted m-t-5">سندات الصرف</div>
        </div>
        </a>
    </div>
    <div class="col-lg-3 col-sm-6">
    <a href="{{ route('bill-type', 'dept') }}">
       <div class="widget-panel widget-style-2 bg-white">
            <i class="md md-tv text-primary"></i>
            <h2 class="m-0 text-dark counter font-600">{{$dept_count}}</h2>
            <div class="text-muted m-t-5">تسديدات المديونية</div>
        </div>
       </a>
    </div>
    <div class="col-lg-3 col-sm-6">
    <a href="{{ url('/admin/purchase/') }}">
        <div class="widget-panel widget-style-2 bg-white">
            <i class="md md-add-box text-primary"></i>
            <h2 class="m-0 text-dark counter font-600">{{$purchases_count}}</h2>
            <div class="text-muted m-t-5">المشتريات</div>
        </div>
        </a>
    </div>

    <div class="col-lg-3 col-sm-6">
        <a href="{{ url('/admin/city/') }}">
        <div class="widget-panel widget-style-2 bg-white">
            <i class="md md-location-city text-pink"></i>
            <h2 class="m-0 text-dark counter font-600">{{$ci_count}}</h2>
            <div class="text-muted m-t-5">المدن</div>
        </div>
        </a>
    </div>
    <div class="col-lg-3 col-sm-6">
        <a href="{{ url('/admin/office/') }}">
        <div class="widget-panel widget-style-2 bg-white">
            <i class="md md-store-mall-directory text-info"></i>
            <h2 class="m-0 text-dark counter font-600">{{$office_count}}</h2>
            <div class="text-muted m-t-5">المكاتب</div>
        </div>
        </a>
    </div>
    <div class="col-lg-3 col-sm-6">
        <a href="{{ url('/admin/shipment/') }}">
        <div class="widget-panel widget-style-2 bg-white">
            <i class="md md-account-child text-custom"></i>
            <h2 class="m-0 text-dark counter font-600">{{$shipments_count}}</h2>
            <div class="text-muted m-t-5">الطرود </div>
        </div>
        </a>
    </div>
    <div class="col-lg-3 col-sm-6">
        <a href="{{ url('/admin/admin/') }}">
        <div class="widget-panel widget-style-2 bg-white">
            <i class="md md-computer text-pink"></i>
            <h2 class="m-0 text-dark counter font-600">{{$a_count}}</h2>
            <div class="text-muted m-t-5">الإدارة</div>
        </div>
        </a>
    </div>
    
</div>