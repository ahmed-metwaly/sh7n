@extends('admin.layouts.app')

{{--@section('title')--}}
{{--{{ trans('admin.sideLevelsTitle') }}--}}
{{--@endsection--}}

{{--@section('sectionName')--}}
{{--{{ trans('admin.sideLevelsTitle') }}--}}
{{--@endsection--}}

{{--@section('pageName')--}}
{{--{{ trans('admin.sideLevelsShowAll') }}--}}
{{--@endsection--}}


@section('content')

    <div class="content">
        <div class="container">
            <!-- Page-Title -->
            <div class="row">

                <form action="{{ route('lv-delete-all', 'levels') }}" method="post">

                    <!-- Highlighting rows and columns -->
                    <div class="panel panel-flat">

                        <table class="table table-bordered table-hover datatable-highlight">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>اسم المستوي</th>
                                <th>عناصر التحكم</th>
                                <th>تاريخ الاضافة</th>
                                <th>تعديل</th>
                                <th>حذف</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($data) > 0)
                                @foreach($data as $value)

                                    <tr>

                                        <td>{{ $value->id }}</td>
                                        <td>
                                            <a href="{{ route('level-details', ['id' => $value->id]) }}">{{ $value->name }}</a>
                                        </td>
                                        <td>
                                            <!--                        --><?php
                                            //
                                            //                        $count = json_decode($value->items);
                                            //                        dd(cou);
                                            //
                                            //                        ?>
                                            {{--                        @if($count > 0 )--}}
                                            <?php $i = 1; ?>
                                            @foreach(json_decode($value->items) as $route => $item)

                                                <a href="{{ route($route) }}" class="btn btn-sm btn-primary"
                                                   style="margin: 3px;">

                                                    @foreach( $menu as $row)
                                                        @foreach( $row['route'] as $key => $val)
                                                            @if($key == $route)
                                                                {{ $val }}
                                                            @endif
                                                        @endforeach
                                                    @endforeach

                                                </a>

                                                <?php if ($i == 3) {
                                                    echo '...';
                                                    break;
                                                } ?>

                                                <?php $i++; ?>

                                            @endforeach

                                            {{--                        @endif--}}

                                        </td>


                                        <td>{{ $value->created_at }}</td>

                                        <td><a href="{{ route('level-edit', ['id' => $value->id]) }}"><i
                                                    class="icon-pencil"
                                                    aria-hidden="true"></i></a></td>
                                        <td><a class="do-delete"
                                               href="{{ route('level-delete', ['id' => $value->id]) }}"><i
                                                    class="icon-trash"></i></a>
                                        </td>
                                    </tr>

                                @endforeach
                            @endif
                            </tbody>
                        </table>
                    </div>

                    <br>




                </form>
            </div>
        </div>
    </div>



@endsection
