<!-- ========== Left Sidebar Start ========== -->
<div class="left side-menu">
    <div class="sidebar-inner slimscrollleft">
        <!--- Divider -->
        <div id="sidebar-menu">
            <ul>
                <li>
                    <a href="{{url('admin')}}" class="waves-effect"><i class="ti-home"></i> <span> لوحة التحكم </span></a>
                </li>

                <li class="has_sub">
                    <a href="{{route('setting.get_setting')}}" class="waves-effect"><i class="md md-settings"></i><span> الإعدادات </span></a>
                </li>

                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="ti-user"></i><span class="label label-info pull-right">{{$a_count}}</span><span> الإدارة </span></a>
                    <ul class="list-unstyled">
                        <li><a href="{{route('admin.create')}}">إضافة مدير جديد</a></li>
                        <li><a href="{{route('admin.index')}}">عرض الكل</a></li>
                    </ul>
                </li>

                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="ti-lock"></i><span class="label label-info pull-right"></span><span> مستويات الإدارة </span></a>
                    <ul class="list-unstyled">
                        <li><a href="{{route('levels')}}">  عرض مستويات الإدارة</a></li>
                        <li><a href="{{route('level-add')}}"> اضافة مستوي جديد</a></li>
                    </ul>
                </li>


                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="md md-location-city"></i><span class="label label-danger pull-right">{{$con_count}}</span><span> الرسائل </span></a>
                    <ul class="list-unstyled">
                        <li><a href="{{route('contact.index')}}">عرض الكل</a></li>
                    </ul>
                </li>
                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="md md-location-city"></i><span class="label label-danger pull-right">{{$ci_count}}</span><span> المدن </span></a>
                    <ul class="list-unstyled">
                        <li><a href="{{route('city.create')}}">إضافة مدينة جديد</a></li>
                        <li><a href="{{route('city.index')}}">عرض الكل</a></li>
                    </ul>
                </li>
                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="md md-location-city"></i><span class="label label-danger pull-right"></span><span> الرسائل النصية </span></a>
                    <ul class="list-unstyled">
                        <li><a href="{{route('sms')}}"> ارسال رسالة نصية</a></li>
                    </ul>
                </li>
                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="md md-perm-media"></i><span> وسائل التواصل  </span></a>
                    <ul class="list-unstyled">
                        {{--<li><a href="{{route('social.create')}}">إضافة رابط جديد</a></li>--}}
                        <li><a href="{{route('social.index')}}">عرض الكل</a></li>
                    </ul>
                </li>


                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="md md-format-line-spacing"></i><span> الخدمات  </span></a>
                    <ul class="list-unstyled">
                        <li><a href="{{route('jop.create')}}">إضافة خدمة جديد</a></li>
                        <li><a href="{{route('jop.index')}}">عرض الكل</a></li>
                    </ul>
                </li>
                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="ti-panel"></i><span> الوكلاء </span></a>
                    <ul class="list-unstyled">
                        <li><a href="{{route('branche.create')}}">إضافة وكيل جديد</a></li>
                        <li><a href="{{route('branche.index')}}">عرض الكل</a></li>
                    </ul>
                </li>

                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="md md-tv"></i><span class="label label-success pull-right">{{$shipments_count}}</span><span> الطرود </span></a>
                    <ul class="list-unstyled">
                        <li><a href="{{route('shipmentReceived')}}">الطرود الواردة </a></li>
                        <li><a href="{{route('shipmentExported')}}">الطرود الصادرة  </a></li>
                        <li><a href="{{route('shipment.create')}}">إضافة طرد جديد </a></li>
                        <li><a href="{{route('shipmentReceiptSheet')}}"> تصدير  سند استلام </a></li>
                        <li><a href="{{route('shipment.index')}}">عرض الكل</a></li>
                    </ul>
                </li>

                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="md md-send"></i><span class="label label-success pull-right"></span><span> الشحنات </span></a>
                    <ul class="list-unstyled">
                        <li><a href="{{route('out-shipment.index')}}"> كل الشحنات </a></li>
                        <li><a href="{{route('out-shipment.create')}}">إضافة شحنه جديدة </a></li>

                    </ul>
                </li>

                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="md md-add-box"></i><span class="label label-success pull-right"></span><span> الإقفال </span></a>
                    <ul class="list-unstyled">
                        <li><a href="{{route('ex.get')}}">عمليات الإقفال</a></li>
                    </ul>
                </li>
                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="md md-add-box"></i><span class="label label-success pull-right"></span><span> حساب الافراد </span></a>
                    <ul class="list-unstyled">
                    <li><a href="{{route('owe')}}"> المدينون</a></li>
                    <li><a href="{{route('ex.get')}}">سداد مديونية</a></li>
                    </ul>
                </li>
                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="md md-add-box"></i><span class="label label-success pull-right">{{$bill_count}}</span><span> السندات </span></a>
                    <ul class="list-unstyled">
                        <li><a href="{{route('bill.create')}}">إضافة سند جديد</a></li>
                        <li><a href="{{route('bill.index')}}">عرض الكل</a></li>
                    </ul>
                </li>
                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="md md-add-box"></i><span class="label label-success pull-right">{{$purchases_count}}</span><span> المشتريات </span></a>
                    <ul class="list-unstyled">
                        <li><a href="{{route('purchase.create')}}">إضافة مشترى جديد</a></li>
                        <li><a href="{{route('purchase.index')}}">عرض الكل</a></li>
                    </ul>
                </li>
                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="md md-subtitles"></i><span class="label label-success pull-right">{{$office_count}}</span><span> المكاتب </span></a>
                    <ul class="list-unstyled">
                        <li><a href="{{route('office.create')}}">إضافة مكتب جديد</a></li>
                        <li><a href="{{route('office.index')}}">عرض الكل</a></li>
                    </ul>
                </li>
                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="md md-subtitles"></i> أساليب الدفع </a>
                    <ul class="list-unstyled">
                        <li><a href="{{route('buy_type.create')}}">إضافة إسلوب دفع جديد </a></li>
                        <li><a href="{{route('buy_type.index')}}">عرض الكل</a></li>
                    </ul>
                </li>
                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="md md-subtitles"></i> حاﻻت الطرود </a>
                    <ul class="list-unstyled">
                        <li><a href="{{route('shipment_type.create')}}">إضافة حالة جديدة </a></li>
                        <li><a href="{{route('shipment_type.index')}}">عرض الكل</a></li>
                    </ul>
                </li>
                <li class="has_sub">
                    <a href="javascript:void(0);" class="waves-effect"><i class="md md-tv"></i><span class="label label-success pull-right">{{$package_type_count}}</span><span> أنواع الطرود </span></a>
                    <ul class="list-unstyled">
                        <li><a href="{{route('package_type.create')}}">إضافة نوع طرد جديد </a></li>
                        <li><a href="{{route('package_type.index')}}">عرض الكل</a></li>
                    </ul>
                </li>

            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>
<!-- Left Sidebar End -->
