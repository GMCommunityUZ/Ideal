@extends('layouts.admin')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h5 >O'qituvchi: {{ $group->teacher->name }}</h5>
                    <h5 >Guruh: {{ $group->name }}</h5>
                    <h5 >Jami summa: {{ $amount }} so'm</h5>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}">Bosh sahifa</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('groupGraphicTeacher', $month) }}">Graphic</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('months') }}">Yillik grafik</a></li>
                        <li class="breadcrumb-item active">O'quvchilar ro'yhati</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">

                        @can('Super Admin')
                            <a href="{{route('graphicAdd', $group->id)}}" class="btn btn-success btn-sm float-right">
                                <span class="fas fa-plus-circle"></span>
                                Qo'shish
                            </a>
                        @endcan
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <!-- Data table -->
                        <table  class="table table-bordered table-striped table-responsive-lg" id="tbl1" role="grid" aria-describedby="dataTable_info">
                            <thead>
                            <tr>
                                <th>№</th>
                                <th>Ism familiya</th>
                                <th>Month</th>
                                <th>To'langan</th>
                                <th>Chegirma</th>
                                <th>Qarz</th>
                                <th>Izoh</th>
                                <th>Status</th>
                                <th class="w-25">Amallar</th>
                            </tr>
                            </thead>
                            @foreach($graphics as $graphic)
                                <tbody>
                                <td>{{$loop->index+1}}</td>
                                <td >@if(isset($graphic->student)) {{$graphic->student->name}} @else Mavjud emas @endif</td>
                                <td>{{date('F', strtotime($graphic->month))}}</td>
                                <td>{{$graphic->paid_amount}} so'm</td>
                                <td>{{$graphic->discount_amount}} so'm</td>
                                <td>{{$graphic->remaining_amount}} so'm</td>
                                <td title="{{$graphic->comment}}">{{substr($graphic->comment, 0, 18 )}}</td>
                                @if($graphic->status == 'To\'liq emas')
                                    <td><a class="badge badge-warning">{{$graphic->status}}</a> </td>
                                @elseif($graphic->status == 'To\'lanmagan')
                                    <td><a class="badge badge-danger">{{$graphic->status}}</a> </td>
                                @else
                                    <td><a class="badge badge-success">{{$graphic->status}}</a> </td>
                                @endif
                                <td class="text-center">
                                    @can('user.delete')
                                        <form action="{{route('graphicDestroy',$graphic->id)}}" method="post">
                                            @csrf
                                            <div class="btn-group">
                                                @can('user.edit')
                                                    <a href="{{ route('graphicEdit', $graphic->id) }}" type="button" class="btn btn-info btn-sm"> <i class="fas fa-edit"></i></a>
                                                @endcan
                                                <input name="_method" type="hidden" value="DELETE">
                                                <button type="button" class="btn btn-danger btn-sm" onclick="if (confirm('Ishonchingiz komilmi?')) { this.form.submit() } "> <i class="fas fa-trash-alt"></i></button>
                                            </div>
                                        </form>
                                    @endcan
                                </td>
                                </tbody>
                            @endforeach
                        </table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer mt-3 ">
                        <div class="float-left">
                            {!! $graphics->links() !!}
                        </div>
                        <div class="float-right">
                            <a href="{{url('graphics/export-excel/'. $group->id.'/month/'. $month)}}" class="btn btn-file btn-sm mt-4"><i class="fas fa-download"></i>  Export Exel</a>
                        </div>
                    </div>
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection
