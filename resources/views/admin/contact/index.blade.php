@extends('admin.layouts.app')
@section('title',$module_name)
@section('content')
    <div class="content">
        <div class="container">
            <!-- Page-Title -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="card-box table-responsive">
                        <table id="datatable-buttons" class="table table-striped table-bordered">
                            <thead>
                            <tr>

                                <th>الاسم</th>
                                <th>رقم الجوال</th>
                                <th>البريد الالكترونى</th>
                                <th>الرسالة</th>
                                <th> حذف</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($contacts as $contact)
                                <tr>
                                    <td>
                                        {{$contact->name}}
                                    </td>
                                    <td>
                                        {{$contact->mobile}}
                                    </td>
                                    <td>
                                        {{$contact->email}}
                                    </td>
                                    <td>
                                        {{$contact->content}}
                                    </td>

                                    <td class="actions">
                                        <div class="row" style="margin-top: 20px">
                                            <div class="col-md-3">
                                                {!! Form::open(['method' => 'DELETE','data-id'=>$contact->id, 'route' => [$route.'.destroy',$contact->id],'class'=>'delete']) !!}
                                                {!! Form::hidden('id', $contact->id) !!}
                                                <button type="button"
                                                        class="btn btn-danger btn-custom waves-effect waves-light"><i
                                                            class="fa fa-trash"></i></button>
                                                {!! Form::close() !!}
                                            </div>

                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div> <!-- container -->
    </div> <!-- content -->
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
                        $("form[data-id='" + id + "']").submit();
                    } else {
                        swal("تم الالغاء", "ما زال العنصر متاح بقاعدة بياناتك :)", "error");
                    }
                });
        });
    </script>

@endsection
