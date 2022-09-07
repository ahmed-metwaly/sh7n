@extends('admin.layouts.app')
@section('title',$module_name)
@section('style')
  <style>
        div .col-md-8 {
            padding: 10px;
            border: 1px solid gray;
            margin: 0;
        }
        .p-print {
            display:none;
        }
        
        .content {
            background: #fff;
        }
        
        .border-none {
            border: none;
        }
        
        /* Voice */

        .voice-border {
            border: 2px solid #4F5185;
            color: #4F5185;
            font-weight: bold;
            margin-top: 16px;
            border-radius: 24px;
            font-family: arial;
            padding: 16px 16px 8px;
            font-size: 18px;
        }
        
        .voice-border img {
            width: 100px;
        }
        
        .voice-border .invoice {
            margin-bottom: -58px;
            border: 2px solid #4F5185;
            background: #fff !important;
            border-radius: 16px;
            padding: 6px;
        }
        
        .voice-border .invoice div {
            border: 1px solid #4F5185;
            border-radius: 12px;
            padding: 16px;
        }
        
        .my-2 {
            margin: 10px 0px;
        }
        
        .mt-5 {
            margin-top: 58px;
        }
        
        .mt-46 {
            margin-top: 46px;
        }
        @media print {
            .p-print {
            display:block;
            
        }
          @page {                
            size: A4;
            margin: 0mm;
          }
        
          html, body {
            width: 1024px;
          }
        
          body {
            margin: 0 auto;
          }
          .dsplay-none {
              display:none;
          }
          .top-text span{
              border-bottom : 1px dashed #000;
          }
        }


        .top-text span{
              border-bottom : 1px dashed #000;
              
          }
          .top-text p{
            line-height: 35px;
          }
    </style>
    <link rel="stylesheet" href="{{url('public/panel/assets/plugins/magnific-popup/css/magnific-popup.css')}}"/>
@stop
@section('content')


@if(isset($rows) && count($rows) > 0)

<div class="content">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="card-box border-none">
                        <h4 class="m-t-0 header-title dsplay-none"><b><i class="icon-pencil before_word"></i>&nbsp;
                                استخراج جرد بتايخ {{ $rFrom }}  الي {{ $rTo }}
                            </b>
                            <hr>
                        </h4>
                        <p class="dsplay-none">
                            <button id="printPage" class="btn btn-success btn-lg">
                                <span style="font-family: 'Glyphicons Halflings' !important;" class="glyphicon glyphicon-print"></span> طباعة
                            </button>
                        </p>
                       
                        </div>
                       
                        <div class="col-md-12 mt-12">
                            <div class="row">
                                <div class="col-xs-12">
                                <p class="lead p-print center">                                 استخراج جرد بتايخ {{ $rFrom }}  الي {{ $rTo }}
  </p>
                                <p class="lead"> - الطرود  </p>
                                    <table class="table voice-border">
                                      <tbody>
                                        <tr class="voice-border">
                                          <th class="voice-border">#</th>
                                          <th class="voice-border">المرسل</th>
                                          <th class="voice-border">المكتب</th>
                                          <th class="voice-border"> اسلوب الدفع</th>

                                          <th class="voice-border">عدد الطرود</th>
                                          <th class="voice-border"> تكلفة المكتب المرسل</th>
                                          <th class="voice-border">تكلفة مكتب المطلق</th>
                                          <th class="voice-border">تكلفة الشحن</th>
                                        </tr>
                                        <?php 
                                        
                                            $sumCont = 0;
                                            $office_price = 0;
                                            $our_price = 0;
                                            $transfer_price = 0;
                                        ?>
                                        @foreach($data as $item)
                                        <tr class="voice-border">
                                          <td class="voice-border">{{ $item->id }}</td>
                                          <td class="voice-border">{{ $item->from }}</td>
                                          <td class="voice-border">{{ $item->o_name }}</td>
                                          <td class="voice-border">{{ $item->b_name }}</td>
                                          <td class="voice-border">{{ countOrderItems($item->id)[0] }}</td>
                                          <td class="voice-border">{{ $item->office_price }}</td>
                                          <td class="voice-border">{{ $item->our_price }}</td>
                                          <td class="voice-border">{{ $item->transfer_price }}</td>
                                          <!-- <td class="voice-border">{{ $item->phone }}</td> -->
                                        </tr>
                                        <?php 
                                            $sumCont += countOrderItems($item->id)[1];
                                            $office_price += $item->office_price;
                                            $our_price += $item->our_price;
                                            $transfer_price += $item->transfer_price;
                                        ?>
                                        @endforeach

                                         <tr class="voice-border">
                                          <td class="voice-border" colspan="4"> الاجمالي</td>
                                          <td class="voice-border">{{ $sumCont }}</td>
                                          <td class="voice-border">{{ $office_price }}</td>
                                          <td class="voice-border">{{ $our_price }}</td>
                                          <td class="voice-border">{{ $transfer_price }}</td>
                                        </tr>
                                      </tbody>
                                    </table>
                                </div>
                                
                                <br>
                                <div class="col-xs-12">
                                <p class="lead"> -  السندات  </p>
                                    <table class="table voice-border">
                                      <tbody>
                                        <tr class="voice-border">
                                          <th class="voice-border">#</th>
                                          <th class="voice-border">العنوان</th>
                                          <th class="voice-border">النوع</th>
                                          <th class="voice-border">  المبلغ</th>
                                        </tr>
                                        <?php 
                                        
                                            $price = 0;
                                        ?>
                                        @foreach($bill as $item)
                                        <tr class="voice-border">
                                          <td class="voice-border">{{ $item->id }}</td>
                                          <td class="voice-border">{{ $item->name }}</td>
                                          <td class="voice-border"><?php 
                                          if($item->type == 'receipt') {
                                            echo 'سند قبض';
                                          } elseif($item->type == 'buy') {
                                            echo ' سند دفع';
                                          } else{
                                                echo 'سند تسديد مديونية';
                                          }
                                          
                                          ?></td>
                                          <td class="voice-border">{{ $item->price }}</td>
                                
                                        </tr>
                                        <?php 
                                            
                                            $price += $item->price;
                                        ?>
                                        @endforeach

                                         <tr class="voice-border">
                                          <td class="voice-border" colspan="3"> الاجمالي</td>
                                          <td class="voice-border">{{ $price }}</td>
                                          
                                        </tr>
                                      </tbody>
                                    </table>
                                </div>

                                <br>
                                <div class="col-xs-12">
                                <p class="lead"> - المشتريات  </p>
                                    <table class="table voice-border">
                                      <tbody>
                                        <tr class="voice-border">
                                          <th class="voice-border">#</th>
                                          <th class="voice-border">العنوان</th>
                                          <th class="voice-border">العدد</th>
                                          <th class="voice-border">  المبلغ</th>
                                        </tr>
                                        <?php 
                                        
                                            $price = 0;
                                            $count = 0;
                                        ?>
                                        @foreach($purchase as $item)
                                        <tr class="voice-border">
                                          <td class="voice-border">{{ $item->id }}</td>
                                          <td class="voice-border">{{ $item->name }}</td>
                                          <td class="voice-border"> {{ $item->count }}</td>
                                          <td class="voice-border">{{ $item->price }}</td>
                                
                                        </tr>
                                        <?php 
                                            
                                            $price += $item->price;
                                            $count += $item->count;
                                        ?>
                                        @endforeach

                                         <tr class="voice-border">
                                          <td class="voice-border" colspan="2"> الاجمالي</td>
                                          <td class="voice-border">{{ $count }}</td>
                                          <td class="voice-border">{{ $price }}</td>
                                          
                                        </tr>
                                      </tbody>
                                    </table>
                                </div>
                               
                            </div>
                        </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>


@else


<div class="content">
        <div class="container">
            <div class="row">
                <div class="col-xs-12">
                    <div class="card-box border-none">
                        <form action="{{ route('owe') }}" method="get">
                        <div class="form-group col-md-4">
                                <label class="control-label"> رقم الجوال</label>
                                <input type="text" required class="form-control" name="phone" >
                            </div>

                            <div class="form-group col-md-4">
                                <label class="control-label">تاريخ البدء</label>
                                <input type="date" required class="form-control" name="from" >
                            </div>
                            <div class="form-group col-md-4">
                                <label class="control-label">تاريخ الانتهاء</label>
                                <input type="date" required class="form-control" name="to" >
                            </div>
                            
                            
                           
                            <div class="form-group">
                            <div class="control-label col-md-push-1">
                                <button type="submit" style="float:left; margin-top: 30px" class="update_button btn btn-success btn-rounded waves-effect waves-light">
                                    استخراج
                                </button>
                            </div>
                        </div>                        
                        
                        </form>
                    
                    </div>
                </div>
            </div>
        </div>
</div>

@endif

@stop
@section('script')
    <script type="text/javascript">
        $(document).ready(function () {

            $('#datatable').dataTable();
            $('#datatable-keytable').DataTable({keys: true});
            $('#datatable-responsive').DataTable();
            $('#datatable-colvid').DataTable({
                "dom": 'C<"clear">lfrtip',
                "colVis": {
                    "buttonText": "Change columns"
                }
            });
            $('#datatable-scroller').DataTable({
                ajax: "public/panel/assets/plugins/datatables/json/scroller-demo.json",
                deferRender: true,
                scrollY: 380,
                scrollCollapse: true,
                scroller: true
            });
            var table = $('#datatable-fixed-header').DataTable({fixedHeader: true});
            var table = $('#datatable-fixed-col').DataTable({
                scrollY: "300px",
                scrollX: true,
                scrollCollapse: true,
                paging: false,
                fixedColumns: {
                    leftColumns: 1,
                    rightColumns: 1
                }
            });
        });
        TableManageButtons.init();

    </script>

    <script>
        $(document).on('click', '.delete', function (e) {
            e.preventDefault();
            var id = $(this).data('id');
            swal({
                    title: "هل انت متأكد من الحذف ؟",
                    text: "لن تستطيع استعادة هذا العنصر مرة أخرى!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: 'btn-danger',
                    confirmButtonText: 'نعم , قم بالحذف!',
                    cancelButtonText: 'ﻻ , الغى عملية الحذف!',
                    closeOnConfirm: false,
                    closeOnCancel: false
                },
                function (isConfirm) {
                    if (isConfirm) {
                        swal("تم الحذف !", "تم حذف العنصر من قاعدة البيانات!", "success");
                        $("form[data-id='"+id+"']").submit();
                    } else {
                        swal("تم الالغاء", "ما زال العنصر متاح بقاعدة بياناتك :)", "error");
                    }
                });
        });
    </script>

@endsection
